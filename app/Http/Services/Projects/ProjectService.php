<?php

namespace App\Http\Services\Projects;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Exception;

use App\Models\{Project};

class ProjectService
{
    /**
     * @var
     */
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getProjects() : Collection
    {
        try {
            $projects = $this->project->all();
            return $projects;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id) : Project | null
    {
        try {
            $project = $this->project->find($id);
            return $project;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($data) : Project
    {
        //Insert Record
        //---------------------------------------------------
        DB::beginTransaction();
            $record = $this->project->create($data);
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
}