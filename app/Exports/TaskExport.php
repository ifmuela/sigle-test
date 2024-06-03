<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use App\Http\Services\Tasks\TaskService;

class TaskExport implements FromCollection, WithHeadings
{
    protected $request;
    protected $TaskService;

    public function __construct(Request $request, TaskService $TaskService)
    {
        $this->request = $request;
        $this->TaskService = $TaskService;
    }

    public function collection()
    {
        return $tasks = $this->TaskService->filterTasks($this->request);
    }

    public function headings(): array
    {
        return [
            'description',
            'project_id',
            'user_id',
            'date_star',
            'date_end',
            'comment'
        ];
    }
}
