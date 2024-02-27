<?php

use App\Http\Controllers\admin\KomentarController as AdminKomentarController;
use App\Http\Controllers\admin\ProjectController as AdminProjectController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\UserController as ControllersUserController;
use App\Http\Requests\KomentarRequest;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("/v1")->group(function () {
    Route::prefix("/auth")->group(function () {
        Route::post("/login", [AuthController::class, "Login"]);
        Route::post("/register", [AuthController::class, "register"]);
        Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
    });

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", [AuthController::class, "User"]);
        Route::put("/user", [ControllersUserController::class, "Update"]);
        Route::resource('/tool', ToolsController::class);
        Route::resource("/project", ProjectController::class);
        Route::post("/project/komentar/{id}", [KomentarController::class, "Store"]);
        Route::get("/project/komentar/{id}", [KomentarController::class, "Show"]);
        Route::delete("/project/komentar/{id}/{komentar:id}", [KomentarController::class, "destroy"]);
        Route::put("/project/{id}", [ProjectController::class, "Update"]);
        Route::post("/like", [LikeController::class, "store"]);
        Route::get("/like/{id}", [LikeController::class, "show"]);
        
        Route::prefix("/admin")->group(function (){
            Route::get("/komentar", [AdminKomentarController::class, "Index"]);
            Route::resource("/config", DashboardController::class);
            Route::resource("/blog", BlogController::class);
            Route::get("/blog/{slug}", [BlogController::class, "show"]);
            Route::get("/latest", [UserController:: class, "Latest"]);
            Route::get("/total", [AdminProjectController::class, "TotalData"]);
            Route::resource("project", AdminProjectController::class);
            // route untuk searching
            Route::get("/allProject", [AdminProjectController::class, "AllProject"]);
            Route::resource("user", UserController::class);
        });

        Route::prefix("/user")->group(function () {
            Route::resource('/project', ControllersUserController::class);
        });
    });
});