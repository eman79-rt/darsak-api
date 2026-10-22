<?php
namespace App\Http\Requests;
use App\Enums\UserRole;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;
class StoreCommentRequest extends FormRequest { public function authorize(): bool {$user=$this->user();if($user?->role!==UserRole::Student)return false;$class=match($this->route('contentType')){'courses'=>Course::class,'lessons'=>Lesson::class,'assignments'=>Assignment::class,default=>null};if(!$class)return false;$content=$class::query()->find($this->route('content'));if(!$content)return false;$course=match(true){$content instanceof Course=>$content,$content instanceof Lesson=>$content->course,$content instanceof Assignment=>$content->course,default=>null};return $course!==null&&$course->students()->whereKey($user->id)->exists();} public function rules(): array {return ['body'=>['required','string','max:3000']];} }
