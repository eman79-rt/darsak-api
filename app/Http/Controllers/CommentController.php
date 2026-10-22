<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
class CommentController extends Controller {public function store(StoreCommentRequest $request,string $contentType,string $content):JsonResponse {$class=match($contentType){'courses'=>Course::class,'lessons'=>Lesson::class,'assignments'=>Assignment::class};$item=$class::findOrFail($content);$comment=$item->comments()->create(['user_id'=>$request->user()->id,'body'=>$request->validated('body')]);return response()->json(['data'=>$comment,'message'=>'تمت إضافة التعليق بنجاح.'],201);}}
