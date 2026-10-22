<?php
namespace Tests\Feature;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ApiTest extends TestCase {use RefreshDatabase; public function test_teacher_can_create_course():void {$teacher=User::create(['name'=>'Teacher','email'=>'t@example.test','password'=>'password','role'=>UserRole::Teacher]);$this->actingAs($teacher)->postJson('/api/courses',['title'=>'New','level'=>'beginner','status'=>'draft','is_free'=>true])->assertCreated()->assertJsonPath('data.title','New');} public function test_teacher_cannot_update_another_teachers_course():void {$one=User::create(['name'=>'One','email'=>'one@example.test','password'=>'password','role'=>UserRole::Teacher]);$two=User::create(['name'=>'Two','email'=>'two@example.test','password'=>'password','role'=>UserRole::Teacher]);$course=Course::create(['teacher_id'=>$two->id,'title'=>'Owned','level'=>'beginner','status'=>'draft','is_free'=>false]);$this->actingAs($one)->patchJson('/api/courses/'.$course->id,['title'=>'Hacked'])->assertForbidden();} public function test_invalid_course_data_returns_arabic_validation_error():void {$teacher=User::create(['name'=>'Teacher','email'=>'tv@example.test','password'=>'password','role'=>UserRole::Teacher]);$this->actingAs($teacher)->postJson('/api/courses',[])->assertUnprocessable()->assertJsonPath('message','البيانات المدخلة غير صحيحة.');} }
