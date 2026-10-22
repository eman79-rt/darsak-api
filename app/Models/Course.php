<?php
namespace App\Models;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Models\Concerns\HasCategories;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use App\Models\Scopes\PublishedCourseScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model { use HasFactory,HasComments,HasImage,HasCategories; protected $fillable=['teacher_id','title','description','level','status','is_free']; protected function casts(): array {return ['level'=>CourseLevel::class,'status'=>CourseStatus::class,'is_free'=>'boolean'];} protected static function booted(): void {static::addGlobalScope(new PublishedCourseScope);} public function teacher(){return $this->belongsTo(User::class,'teacher_id');} public function lessons(){return $this->hasMany(Lesson::class)->orderBy('order');} public function students(){return $this->belongsToMany(User::class,'enrollments','course_id','student_id')->withPivot(['enrolled_at','progress']);} public function scopePublished($query){return $query->where('status',CourseStatus::Published->value);} public function scopeFree($query){return $query->where('is_free',true);} public function scopeAtLevel($query,CourseLevel $level){return $query->where('level',$level->value);} }
