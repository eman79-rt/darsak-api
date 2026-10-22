<?php
namespace App\Http\Requests;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreCourseRequest extends FormRequest { public function authorize(): bool {return $this->user()?->role===UserRole::Teacher;} public function rules(): array {return ['title'=>['required','string','max:255'],'description'=>['nullable','string'],'level'=>['required',Rule::enum(\App\Enums\CourseLevel::class)],'status'=>['required',Rule::enum(\App\Enums\CourseStatus::class)],'is_free'=>['required','boolean']];} }
