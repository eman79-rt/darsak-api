<?php
namespace App\Http\Requests;
use App\Enums\UserRole;
use App\Rules\ApprovedVideoUrl;
use Illuminate\Foundation\Http\FormRequest;
class StoreLessonRequest extends FormRequest { public function authorize(): bool {$course=$this->route('course'); return $this->user()?->role===UserRole::Teacher && $course && $course->teacher_id===$this->user()->id;} public function rules(): array {return ['title'=>['required','string','max:255'],'video_url'=>['required','url',new ApprovedVideoUrl],'order'=>['required','integer','min:1']];} }
