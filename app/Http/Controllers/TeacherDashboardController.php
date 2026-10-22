<?php
namespace App\Http\Controllers;
use App\Enums\UserRole;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class TeacherDashboardController extends Controller {public function __invoke(Request $request,CourseService $service):JsonResponse {abort_unless($request->user()->role===UserRole::Teacher,403);return response()->json(['data'=>$service->latestComments($request->user()->id)]);}}
