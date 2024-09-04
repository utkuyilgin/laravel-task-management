<?php



use App\Http\Controllers\Api\UserController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth:web'], function () {
    
    Route::get('/fetchProjects', [ProjectController::class, 'fetchProjects'])->name('api.project.fetchProjects');
    Route::post('/create/project', [ProjectController::class, 'store'])->name('api.project.store');
    Route::post('/update/project/{id}', [ProjectController::class, 'update'])->name('api.project.update');
    Route::post('/delete/project/{id}', [ProjectController::class, 'destroy'])->name('api.project.destroy');


    Route::get('/fetchTasks/{project_id}', [TaskController::class, 'fetchTasks'])->name('api.task.fetchTasks');
    Route::get('/tasks/{project_id}', [TaskController::class, 'index'])->name('api.task.index');
    Route::post('/create/task', [TaskController::class, 'store'])->name('api.task.store');
    Route::post('/update/task/{id}', [TaskController::class, 'update'])->name('api.task.update');
    Route::post('/delete/task/{id}', [TaskController::class, 'destroy'])->name('api.task.destroy');

    Route::get('/fetchUsers', [UserController::class, 'fetchUsers'])->name('api.role.fetchUsers');
    Route::post('/create/user', [UserController::class, 'store'])->name('api.user.store');
    Route::post('/update/user/{id}', [UserController::class, 'update'])->name('api.user.update');
    Route::post('/delete/user/{id}', [UserController::class, 'destroy'])->name('api.user.destroy');

    Route::get('/fetchRoles', [RoleController::class, 'fetchRoles'])->name('api.role.fetchRoles');
    Route::post('/create/role', [RoleController::class, 'store'])->name('api.role.store');
    Route::post('/update/role/{id}', [RoleController::class, 'update'])->name('api.role.update');
    Route::get('/delete/role/{id}', [RoleController::class, 'destroy'])->name('api.role.destroy');

});

