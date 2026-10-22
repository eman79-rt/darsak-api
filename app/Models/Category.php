<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model { protected $fillable=['name','slug']; public function courses(){return $this->morphedByMany(Course::class,'categoryable');} public function lessons(){return $this->morphedByMany(Lesson::class,'categoryable');} public function assignments(){return $this->morphedByMany(Assignment::class,'categoryable');} }
