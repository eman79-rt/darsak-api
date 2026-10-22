<?php
namespace App\Http\Requests;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCourseRequest extends FormRequest { public function authorize(): bool {$course=$this->route('course'); return $this->user()?->role===UserRole::Teacher && $course && $course->teacher_id===$this->user()->id;} public function rules(): array {return ['title'=>['sometimes','required','string','max:255'],'description'=>['sometimes','nullable','string'],'level'=>['sometimes',Rule::enum(\App\Enums\CourseLevel::class)],'status'=>['sometimes',Rule::enum(\App\Enums\CourseStatus::class)],'is_free'=>['sometimes','boolean']];} }
