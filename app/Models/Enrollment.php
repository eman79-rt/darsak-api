<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enrollment extends Model { protected $fillable=['student_id','course_id','enrolled_at','progress']; protected function casts(): array {return ['enrolled_at'=>'datetime','progress'=>'integer'];} }
