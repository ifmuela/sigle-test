<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

use App\Http\Services\Tasks\TaskService;
use App\Exports\TaskExport;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    public $TaskService;

    public function __construct(TaskService $TaskService)
    {
        $this->TaskService = $TaskService;
    }

    public function getTasks() : JsonResponse
    {
        try {
            $tasks = $this->TaskService->getTasks();
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($tasks, 200);
    }

    public function getTaskById($id) : JsonResponse
    {
        try {
            $task = $this->TaskService->getById($id);
            if (!$task) {
                return response()->json(['msg' => 'Task not found'], 404);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($task, 200);
    }

    public function createTask(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 433);
        }

        try {
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $task = $this->TaskService->store($data);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json([
            'data' => $task,
        ], 201);
    }

    public function deleteTask($id) : JsonResponse
    {
        try {
            $task = $this->TaskService->delete($id);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json(['message' => 'success'], 204);
    }

    public function filterTask(Request $request) : JsonResponse
    {
        try {
            $tasks = $this->TaskService->filterTasks($request);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json([
            'data' => $tasks,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        try {
            return Excel::download(new TaskExport($request, $this->TaskService), 'tasks.xlsx', \Maatwebsite\Excel\Excel::XLSX, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
