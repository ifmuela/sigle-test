<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::get('/test', function () : array {
    return [1, 2, 3];
});

Route::prefix('users')->group(function () {
    Route::get('/', 'App\Http\Controllers\UserController@getUsers');
    Route::get('/{id}', 'App\Http\Controllers\UserController@getUserById');
    Route::post('/create-user', 'App\Http\Controllers\UserController@createUser');
    Route::delete('/{id}', 'App\Http\Controllers\UserController@deleteUser');
    Route::post('/login', 'App\Http\Controllers\UserController@login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/return-user', 'App\Http\Controllers\UserController@returnUser');

    Route::prefix('projects')->group(function () {
        Route::get('/', 'App\Http\Controllers\ProjectController@getProjects');
        Route::get('/{id}', 'App\Http\Controllers\ProjectController@getProjectById');
        Route::post('/create-project', 'App\Http\Controllers\ProjectController@createProject');
        Route::delete('/{id}', 'App\Http\Controllers\ProjectController@deleteProject');
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/', 'App\Http\Controllers\TaskController@getTasks');
        Route::get('/{id}', 'App\Http\Controllers\TaskController@getTaskById');
        Route::post('/create-task', 'App\Http\Controllers\TaskController@createTask');
        Route::delete('/{id}', 'App\Http\Controllers\TaskController@deleteTask');
        Route::post('/filter/search', 'App\Http\Controllers\TaskController@filterTask');
        Route::get('/export/excel', 'App\Http\Controllers\TaskController@exportExcel');
    });
});
