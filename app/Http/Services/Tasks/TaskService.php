<?php

namespace App\Http\Services\Tasks;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Exception;

use App\Models\{Task};

class TaskService
{
    /**
     * @var
     */
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTasks() : Collection
    {
        try {
            $tasks = $this->task->all();
            return $tasks;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id) : Task | null
    {
        try {
            $task = $this->task->find($id);
            return $task;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($data) : Task
    {
        //Insert Record
        //---------------------------------------------------
        DB::beginTransaction();
            $record = $this->task->create($data);
        DB::commit();
        //---------------------------------------------------

        return $record;
    }


    public function delete(int $id): bool
    {
        //Delete Record
        //-------------------------------------------------------
        DB::beginTransaction();
            $record = self::getById($id);
            $record->delete();
        DB::commit();
        //-------------------------------------------------------

        return true;
    }

    /**
     * Function to get user by company data in table
     *
     * @return  TaskCollection
     */
    public function filterTasks($request) : LengthAwarePaginator
    {
        try {
            $paginate = $request->per_page ?? 20;
            $tasks = $this->task->query()
                ->when(
                    (isset($request->user_id) && $request->user_id),
                    function ($query) use ($request) {
                        $query->where('user_id', $request->user_id);
                    }
                )
                ->when(
                    (isset($request->project_id) && $request->project_id),
                    function ($query) use ($request) {
                        $query->where('project_id', $request->project_id);
                    }
                )
                ->paginate($paginate);

            return $tasks;
        } catch (Exception $e) {
            throw $e;
        }
    }
}