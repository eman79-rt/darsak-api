<?php
namespace App\Models;
use App\Models\Concerns\HasCategories;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Model;
class Lesson extends Model { use HasComments,HasImage,HasCategories; protected $fillable=['course_id','title','video_url','order']; public function course(){return $this->belongsTo(Course::class);} }
