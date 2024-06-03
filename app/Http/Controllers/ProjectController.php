<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

use App\Http\Services\Projects\ProjectService;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    public $ProjectService;

    public function __construct(ProjectService $ProjectService)
    {
        $this->ProjectService = $ProjectService;
    }

    public function getProjects() : JsonResponse
    {
        try {
            $projects = $this->ProjectService->getProjects();
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($projects, 200);
    }

    public function getProjectById($id) : JsonResponse
    {
        try {
            $project = $this->ProjectService->getById($id);
            if (!$project) {
                return response()->json(['msg' => 'Project not found'], 404);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($project, 200);
    }

    public function createProject(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 433);
        }

        try {
            $data = $request->all();
            $project = $this->ProjectService->store($data);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json([
            'data' => $project,
        ], 201);
    }

    public function deleteProject($id) : JsonResponse
    {
        try {
            $project = $this->ProjectService->delete($id);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json(['message' => 'success'], 204);
    }
}
