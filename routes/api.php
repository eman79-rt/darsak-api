<?php

use App\Http\Controllers\CategoryContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('courses', CourseController::class)->only(['index','show','store','update']);
    Route::post('courses/{course}/lessons', [LessonController::class,'store']);
    Route::post('{contentType}/{content}/comments', [CommentController::class,'store'])->whereIn('contentType',['courses','lessons','assignments']);
    Route::get('categories/{category}/content', CategoryContentController::class);
    Route::get('teacher/latest-comments', TeacherDashboardController::class);
});
