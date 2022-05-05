<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpiryDatesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\PlanogramController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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



Auth::routes([
    'register' => false,
    'reset' => false
]);

// Zalogowani

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'notifications'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/notifications', [HomeController::class, 'notification'])->name('notifications');
        Route::post('/notifications', [HomeController::class, 'readNotification'])->name('readNotification');


        //terminy user
        Route::prefix('expiry-date-system')->group(function () {
            Route::get('/', function () {return view('eds.index');})->name('edsPanel');
            Route::get('/list', [ExpiryDatesController::class, 'index'])->name('edsList');
            Route::get('/add', [ExpiryDatesController::class, 'create'])->name('edsAdd');
            Route::post('/add-date', [ExpiryDatesController::class, 'store'])->name('edsAddDate');
            Route::post('/add-product', [ExpiryDatesController::class, 'storeProduct'])->name('edsAddProduct');
            Route::get('/edit', [ExpiryDatesController::class, 'edit'])->name('edsEdit');
            Route::get('/show/{id}', [ExpiryDatesController::class, 'show'])->name('edsShow');
            Route::post('/update/{id}', [ExpiryDatesController::class, 'update'])->name('edsUpdate');
            Route::get('/destroy/{id}', [ExpiryDatesController::class, 'destroy'])->name('edsDestroy');
            Route::get('/report', function () {return view('eds.report');})->name('edsReport');
            Route::post('/report/generate', [ExpiryDatesController::class, 'report'])->name('edsGenerate');

        });

        //Podręcznik user
        Route::group(['prefix' => 'guide'], function () {
            Route::get('/', [GuideController::class, 'indexUser'])->name('guideList');
            Route::get('/show/{id}', [GuideController::class, 'show'])->name('guideShow');
        });


        //Planogramy user
        Route::group(['prefix' => 'planograms'], function () {
            Route::get('/', [PlanogramController::class, 'index'])->name('planograms');
            Route::get('/list', [PlanogramController::class, 'list'])->name('userPlanograms');
            Route::get('/my', [PlanogramController::class, 'my'])->name('myPlanograms');
            Route::get('/show/{id}', [PlanogramController::class, 'show'])->name('planogramShow');
            Route::get('/download/{id}', [PlanogramController::class, 'download'])->name('planogramDownload');
        });


        //Grafik user
        Route::prefix('schedule')->group(function () {
            Route::get('/', function () {return view('schedule.user');})->name('userSchedule');
            Route::get('/preferences', [PreferenceController::class, 'index'])->name('userPreferences');
            Route::get('/preferences/destroy/{id}', [PreferenceController::class, 'destroy'])->name('preferenceDestroy');
            Route::post('/preferences/add', [PreferenceController::class, 'store'])->name('preferenceAdd');
            Route::get('/current', [ScheduleController::class, 'current'])->name('userCurrent');
            Route::get('/individual', [ScheduleController::class, 'individual'])->name('userIndividual');
            Route::get('/archives', [ScheduleController::class, 'index'])->name('userArchives');
            Route::get('/archives/{id}', [ScheduleController::class, 'show'])->name('scheduleShow');
        });


        //admin dashboard
        Route::group([
            'prefix' => 'admin',
            'middleware' => 'can:isAdmin'
        ], function () {
            Route::get('/', function () {return view('admin.admin');})->name('adminPanel');
            Route::post('/upload', [GuideController::class, 'uploadTrix'])->name('adminUploadTrix');

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UserController::class, 'index'])->name('adminUsers');
                Route::post('/add', [UserController::class, 'store'])->name('adminUsersAdd');
                Route::get('/edit/{user}', [UserController::class, 'edit'])->name('adminUsersEdit');
                Route::post('/edit/{user}', [UserController::class, 'update'])->name('adminUserUpdate');
            });

            Route::group(['prefix' => 'tasks'], function () {
                Route::get('/', [TaskController::class, 'index'])->name('adminTasks');
                Route::get('/show/{task}', [TaskController::class, 'show'])->name('adminTaskShow');
                Route::get('/create', [TaskController::class, 'create'])->name('adminTaskCreate');
                Route::post('/store', [TaskController::class, 'store'])->name('adminTaskStore');
                Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('adminTaskEdit');
                Route::post('/update/{task}', [TaskController::class, 'update'])->name('adminTaskUpdate');
                Route::get('/copy/{task}', [TaskController::class, 'copy'])->name('adminTaskCopy');
                Route::get('/archive/{task}', [TaskController::class, 'archive'])->name('adminTaskArchive');
                Route::get('/archives', [TaskController::class, 'archives'])->name('adminTaskArchives');
            });

            Route::group(['prefix' => 'messages'], function () {
                Route::get('/', [UserController::class, 'index'])->name('adminMessages');
            });

            Route::group(['prefix' => 'planograms'], function () {
                Route::get('/', [PlanogramController::class, 'adminList'])->name('adminPlanogram');
                Route::post('/add', [PlanogramController::class, 'add'])->name('adminPlanogramAdd');
                Route::get('/edit/{id}', [PlanogramController::class, 'edit'])->name('adminPlanogramEdit');
                Route::get('/hide/{id}', [PlanogramController::class, 'hide'])->name('adminPlanogramHide');
                Route::get('/publish/{id}', [PlanogramController::class, 'publish'])->name('adminPlanogramPublish');
                Route::post('/update', [PlanogramController::class, 'update'])->name('adminPlanogramUpdate');
                Route::get('/file/delete/{id}', [PlanogramController::class, 'deleteFile'])->name('adminPlanogramDeleteFile');
            });

            Route::group(['prefix' => 'guide'], function () {
                Route::get('/', function () {return view('guide.admin');})->name('adminGuide');
                Route::get('/list', [GuideController::class, 'index'])->name('adminGuideList');
                Route::get('/create', [GuideController::class, 'create'])->name('adminGuideCreate');
                Route::post('/store', [GuideController::class, 'store'])->name('adminGuideStore');
                Route::get('/edit/{id}', [GuideController::class, 'edit'])->name('adminGuideEdit');
                Route::post('/public', [GuideController::class, 'public'])->name('adminGuidePublic');
                Route::post('/unpublic', [GuideController::class, 'unpublic'])->name('adminGuideUnPublic');
                Route::post('/update', [GuideController::class, 'update'])->name('adminGuideUpdate');
            });

            Route::group(['prefix' => 'schedule'], function () {
                Route::get('/', function () {return view('schedule.admin');})->name('adminSchedule');
                Route::get('/preferences', [PreferenceController::class, 'indexAdmin'])->name('adminPreferences');
                Route::get('/create', [ScheduleController::class, 'create'])->name('scheduleCreate');
                Route::post('/create', [ScheduleController::class, 'save'])->name('scheduleSave');
                Route::get('/list', [ScheduleController::class, 'indexAdmin'])->name('scheduleManage');
                Route::get('/public/{id}', [ScheduleController::class, 'public'])->name('schedulePublic');
                Route::get('/unpublic/{id}', [ScheduleController::class, 'unPublic'])->name('scheduleUnPublic');
                Route::get('/edit/{id}', [ScheduleController::class, 'edit'])->name('scheduleEdit');
                Route::post('/edit', [ScheduleController::class, 'store'])->name('scheduleStore');

                Route::group(['prefix' => 'shift'], function () {
                    Route::get('/', [ShiftController::class, 'index'])->name('shiftList');
                    Route::post('/add', [ShiftController::class, 'store'])->name('shiftAdd');
                    Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('shiftEdit');
                    Route::post('/edit/{id}', [ShiftController::class, 'update'])->name('shiftUpdate');
                });
            });
        });
    });
});


Route::get('/', [HomeController::class, 'index'])->name('index');
