<?php

use App\Http\Controllers\Admin\HomeController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;

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

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

//auth routes
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:web'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('/create/project', [ProjectController::class, 'create'])->name('admin.project.create');
    Route::post('/create/project', [ProjectController::class, 'store'])->name('admin.project.store');
    Route::get('/edit/project/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
    Route::post('/update/project/{id}', [ProjectController::class, 'update'])->name('admin.project.update');
    Route::post('/delete/project/{id}', [ProjectController::class, 'destroy'])->name('admin.project.destroy');

    Route::get('/tasks/{project_id}', [TaskController::class, 'index'])->name('admin.task.index');
    Route::get('/create/task/{project_id?}', [TaskController::class, 'create'])->name('admin.task.create');
    Route::post('/create/task', [TaskController::class, 'store'])->name('admin.task.store');
    Route::get('/edit/task/{id}', [TaskController::class, 'edit'])->name('admin.task.edit');
    Route::post('/update/task/{id}', [TaskController::class, 'update'])->name('admin.task.update');
    Route::post('/delete/task/{id}', [TaskController::class, 'destroy'])->name('admin.task.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/fetchUsers', [RoleController::class, 'fetchUsers'])->name('admin.role.fetchUsers');
    Route::get('/create/user', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/create/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/edit/user/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/edit/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/delete/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('admin.role.index');
    Route::get('/fetchRoles', [RoleController::class, 'fetchRoles'])->name('admin.role.fetchRoles');
    Route::get('/create/role', [RoleController::class, 'create'])->name('admin.role.create');
    Route::post('/create/role', [RoleController::class, 'store'])->name('admin.role.store');
    Route::get('/edit/role/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
    Route::post('/edit/role/{id}', [RoleController::class, 'update'])->name('admin.role.update');
    Route::get('/delete/role/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');

});

