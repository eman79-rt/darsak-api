<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreLessonRequest;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
class LessonController extends Controller {public function store(StoreLessonRequest $request,string $course):JsonResponse {$lesson=Lesson::create($request->validated()+['course_id'=>$course]);return response()->json(['data'=>$lesson,'message'=>'تم إنشاء الدرس بنجاح.'],201);}}
