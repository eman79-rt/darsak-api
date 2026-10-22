<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
class CategoryContentController extends Controller {public function __invoke(Category $category):JsonResponse {$category->load(['courses'=>fn($q)=>$q->with(['teacher:id,name','image'])->withCount('lessons'),'lessons'=>fn($q)=>$q->with(['course:id,title','image']),'assignments'=>fn($q)=>$q->with('course:id,title')]);return response()->json(['data'=>['category'=>$category->only(['id','name','slug']),'courses'=>$category->courses,'lessons'=>$category->lessons,'assignments'=>$category->assignments]]);}}
