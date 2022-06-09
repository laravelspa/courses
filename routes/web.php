<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StudentController;
use App\Models\Course;
use App\Models\Event;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard Homepage 
    // Fix Register Access If User Not have Role
    // Add Role Middleware To Block Any Users Not Have Role

    Route::prefix("my-profile")->group(function () {

        Route::get('/', [UserController::class, "profile"])->name('profile');

        Route::post('/update', [UserController::class, "updateProfile"])->name('profile.update');
    });

    Route::get('/', function () {
        // $user = auth()->user();
        // dd($user->getPermissionsViaRoles());
        $events = Event::all();

        $courses = Course::all()->count();

        $students = Student::all()->count();

        $teachers = User::with("roles")->whereHas("roles", function ($query) {
            $query->whereIn("name", [User::R_TEACHER]);
        })->count();

        $users = User::all()->count();

        $data = [
            "events" => $events,
            "courses" => $courses,
            "students" => $students,
            "teachers" => $teachers,
            "users" => $users,
        ];

        return view('dashboard', $data);
    })->middleware(['role:owner|teacher|admin'])->name('dashboard');

    // Users Group
    Route::get('/teachers', [UserController::class, "teachers"])->name("teachers")->middleware(['permission:' . User::P_VIEW_USER]);
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, "all"])->name("users")->middleware(['permission:' . User::P_VIEW_USER]);
        Route::post('/create', [UserController::class, "create"])->name("users.create")->middleware(['permission:' . User::P_ADD_USER]);
        Route::post('/approve', [UserController::class, "approve"])->name("users.approve")->middleware(['permission:' . User::P_EDIT_USER]);
        Route::post('/not-approve', [UserController::class, "notApprove"])->name("users.notApprove")->middleware(['permission:' . User::P_EDIT_USER]);
        // Route::get('/{id}/edit', [UserController::class, "edit"])->name("users.edit")->middleware(['permission:' . User::P_EDIT_USER]);
        Route::post('/edit', [UserController::class, "update"])->name("users.update")->middleware(['permission:' . User::P_EDIT_USER]);
        Route::post('/delete', [UserController::class, "delete"])->name("users.delete")->middleware(['permission:' . User::P_DELETE_USER]);
    });

    // Settings Group
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, "index"])->name("settings.index")->middleware(['permission:' . User::P_VIEW_SETTING]);
        Route::get('/create', [SettingsController::class, "create"])->name("settings.create")->middleware(['permission:' . User::P_ADD_SETTING]);
        Route::post('/store', [SettingsController::class, "store"])->name("settings.store")->middleware(['permission:' . User::P_ADD_SETTING]);
        Route::get('/{setting}/edit', [SettingsController::class, "edit"])->name("settings.edit")->middleware(['permission:' . User::P_EDIT_SETTING]);
        Route::put('/{setting}/edit', [SettingsController::class, "update"])->name("settings.update")->middleware(['permission:' . User::P_EDIT_SETTING]);
    });

    // Courses Group
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, "index"])->name('courses.index')->middleware(['permission:' . User::P_VIEW_COURSE]);
        Route::post('/create', [CourseController::class, "store"])->name('courses.store')->middleware(['permission:' . User::P_ADD_COURSE]);
        Route::post('/update', [CourseController::class, "update"])->name('courses.update')->middleware(['permission:' . User::P_EDIT_COURSE]);
        Route::delete('/delete', [CourseController::class, "destroy"])->name('courses.destroy')->middleware(['permission:' . User::P_DELETE_COURSE]);
        Route::get('/archived', [CourseController::class, "archived"])->name('courses.archived')->middleware(['permission:' . User::P_VIEW_COURSE]);
    });

    // Programs Group
    Route::prefix('courses/{courseId}/programs')->group(function () {
        Route::get('/', [ProgramController::class, "index"])->name('programs.index')->middleware(['permission:' . User::P_VIEW_PROGRAM]);
        Route::post('/create', [ProgramController::class, "store"])->name('programs.store')->middleware(['permission:' . User::P_ADD_PROGRAM]);
        Route::post('/update', [ProgramController::class, "update"])->name('programs.update')->middleware(['permission:' . User::P_EDIT_PROGRAM]);
        Route::post('/delete', [ProgramController::class, "destroy"])->name('programs.destroy')->middleware(['permission:' . User::P_DELETE_PROGRAM]);
        Route::get('/archived', [ProgramController::class, "archived"])->name('programs.archived')->middleware(['permission:' . User::P_VIEW_PROGRAM]);
    });

    // Tables Group
    Route::prefix('courses/{courseId}/programs/{programId}/tables')->group(function () {
        Route::get('/', [TableController::class, "index"])->name('tables.index')->middleware(['permission:' . User::P_VIEW_TABLE]);
        Route::post('/create', [TableController::class, "store"])->name('tables.store')->middleware(['permission:' . User::P_ADD_TABLE]);
        Route::post('/update', [TableController::class, "update"])->name('tables.update')->middleware(['permission:' . User::P_EDIT_TABLE]);
        Route::post('/delete', [TableController::class, "destroy"])->name('tables.destroy')->middleware(['permission:' . User::P_DELETE_TABLE]);
    });

    // Student Group
    Route::get('/students', [StudentController::class, "all"])->name('students.all')->middleware(['permission:' . User::P_VIEW_STUDENT]);
    Route::post('/students', [StudentController::class, "allStudents"])->name('students.ajax')->middleware(['permission:' . User::P_VIEW_STUDENT]);
    Route::post('/students/import', [StudentController::class, "studentsImport"])->name('students.import')->middleware(['permission:' . User::P_ADD_STUDENT]);
    Route::prefix('courses/{courseId}/students')->group(function () {
        Route::get('/', [StudentController::class, "index"])->name('students.index')->middleware(['permission:' . User::P_VIEW_STUDENT]);
        Route::post('/create', [StudentController::class, "store"])->name('students.store')->middleware(['permission:' . User::P_ADD_STUDENT]);
        Route::post('/update', [StudentController::class, "update"])->name('students.update')->middleware(['permission:' . User::P_EDIT_STUDENT]);
        Route::post('/delete', [StudentController::class, "destroy"])->name('students.destroy')->middleware(['permission:' . User::P_DELETE_STUDENT]);
    });

    // Events Group
    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, "index"])->name('events.index')->middleware(['permission:' . User::P_VIEW_EVENT]);
        Route::post('/create', [EventController::class, "store"])->name('events.store')->middleware(['permission:' . User::P_ADD_EVENT]);
        Route::post('/update', [EventController::class, "update"])->name('events.update')->middleware(['permission:' . User::P_EDIT_EVENT]);
        Route::post('/delete', [EventController::class, "destroy"])->name('events.destroy')->middleware(['permission:' . User::P_DELETE_EVENT]);
        Route::get('/archived', [EventController::class, "archived"])->name('events.archived')->middleware(['permission:' . User::P_VIEW_EVENT]);
    });
});


require __DIR__ . '/auth.php';