<?php
namespace App\Services;
use App\Enums\CourseStatus;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
class CourseService { public function create(array $data,int $teacherId): Course {return DB::transaction(fn()=>Course::create($data+['teacher_id'=>$teacherId]));} public function update(Course $course,array $data): Course {$course->update($data);return $course->refresh();} public function teacherCourses(int $teacherId){return Course::withoutGlobalScope(\App\Models\Scopes\PublishedCourseScope::class)->where('teacher_id',$teacherId)->with(['teacher:id,name','image','categories'])->withCount(['lessons','students'])->paginate(20);} public function latestComments(int $teacherId){return Comment::query()->whereHasMorph('commentable',[Course::class,Lesson::class,\App\Models\Assignment::class],function($q,$type)use($teacherId){if($type===Course::class)$q->where('teacher_id',$teacherId);else $q->whereHas('course',fn($c)=>$c->where('teacher_id',$teacherId));})->with(['user:id,name','commentable'=>function($m){$m->morphWith([Course::class=>['teacher:id,name'],Lesson::class=>['course:id,title'],\App\Models\Assignment::class=>['course:id,title']]);}])->latest()->limit(30)->get();} }
