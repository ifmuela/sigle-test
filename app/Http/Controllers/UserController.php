<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Services\Users\UserService;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    public $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function getUsers() : JsonResponse
    {
        try {
            $users = $this->UserService->getUsers();
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($users, 200);
    }

    public function getUserById($id) : JsonResponse
    {
        try {
            $user = $this->UserService->getById($id);
            if (!$user) {
                return response()->json(['msg' => 'User not found'], 404);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json($user, 200);
    }

    public function createUser(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 433);
        }

        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = $this->UserService->store($data);
            $token = $this->UserService->login($user);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json([
            'data' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 433);
        }

        try {
            $user = $this->UserService->filter($request->email);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'msg' => 'Bad creds'
                ], 401);
            }

            $token = $this->UserService->login($user);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function returnUser(Request $request) : JsonResponse
    {
        return response()->json([
            'user' => $request->user()
        ], 201);
    }

    public function deleteUser($id) : JsonResponse
    {
        try {
            $user = $this->UserService->delete($id);
        } catch (Exception $e) {
            throw $e;
        }

        return response()->json(['message' => 'success'], 204);
    }
}
