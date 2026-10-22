<?php
namespace App\Http\Controllers;
use App\Enums\UserRole;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CourseController extends Controller {public function __construct(private CourseService $service){} public function index(Request $request):JsonResponse {$courses=$request->user()->role===UserRole::Teacher?$this->service->teacherCourses($request->user()->id):Course::with(['teacher:id,name','image','categories'])->withCount(['lessons','students'])->paginate(20);return response()->json(['data'=>$courses]);} public function show(Course $course):JsonResponse {$course->load(['teacher:id,name','lessons.image','lessons.categories','image','categories'])->loadCount('students');return response()->json(['data'=>$course]);} public function store(StoreCourseRequest $request):JsonResponse {$course=$this->service->create($request->validated(),$request->user()->id);return response()->json(['data'=>$course,'message'=>'تم إنشاء الكورس بنجاح.'],201);} public function update(UpdateCourseRequest $request,Course $course):JsonResponse{return response()->json(['data'=>$this->service->update($course,$request->validated()),'message'=>'تم تعديل الكورس بنجاح.']);}}
