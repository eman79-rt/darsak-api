<?php
namespace Database\Seeders;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {public function run():void {$teacher=User::create(['name'=>'مدرس تجريبي','email'=>'teacher@darsak.test','password'=>Hash::make('password'),'role'=>UserRole::Teacher]);$student=User::create(['name'=>'طالب تجريبي','email'=>'student@darsak.test','password'=>Hash::make('password'),'role'=>UserRole::Student]);$student2=User::create(['name'=>'طالب ثان','email'=>'student2@darsak.test','password'=>Hash::make('password'),'role'=>UserRole::Student]);$admin=User::create(['name'=>'مدير المنصة','email'=>'admin@darsak.test','password'=>Hash::make('password'),'role'=>UserRole::Admin]);$sql=Category::create(['name'=>'SQL','slug'=>'sql']);$laravel=Category::create(['name'=>'Laravel','slug'=>'laravel']);$courses=[];foreach([['أساسيات SQL',CourseLevel::Beginner,CourseStatus::Published,true],['Laravel API',CourseLevel::Intermediate,CourseStatus::Published,false],['كورس مسودة',CourseLevel::Advanced,CourseStatus::Draft,false]] as [$title,$level,$status,$free]){$c=Course::create(['teacher_id'=>$teacher->id,'title'=>$title,'description'=>'محتوى تجريبي للمنصة','level'=>$level,'status'=>$status,'is_free'=>$free]);$c->categories()->attach($title==='أساسيات SQL'?$sql->id:$laravel->id);$courses[]=$c;for($i=1;$i<=3;$i++){$lesson=Lesson::create(['course_id'=>$c->id,'title'=>"الدرس $i: $title",'video_url'=>'https://www.youtube.com/watch?v=dQw4w9WgXcQ','order'=>$i]);$lesson->categories()->attach($title==='أساسيات SQL'?$sql->id:$laravel->id);Comment::create(['user_id'=>$student->id,'commentable_type'=>'lesson','commentable_id'=>$lesson->id,'body'=>'شرح واضح ومفيد']);}}Enrollment::create(['student_id'=>$student->id,'course_id'=>$courses[0]->id,'progress'=>35]);Enrollment::create(['student_id'=>$student->id,'course_id'=>$courses[1]->id,'progress'=>70]);Enrollment::create(['student_id'=>$student2->id,'course_id'=>$courses[0]->id,'progress'=>10]);foreach($courses as $course)Comment::create(['user_id'=>$student->id,'commentable_type'=>'course','commentable_id'=>$course->id,'body'=>'هل يوجد ملف مرفق؟']);$courses[0]->comments()->create(['user_id'=>$student2->id,'body'=>'ممتاز']);$token=$teacher->createToken('postman')->plainTextToken;$student->createToken('postman')->plainTextToken;file_put_contents(storage_path('app/seed-tokens.txt'),"Teacher token: $token
Student token: ".$student->tokens()->latest()->first()->token."
Admin email: admin@darsak.test
Password: password
');}}
