<?php
namespace App\Models;
use App\Models\Concerns\HasCategories;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Model;
class Assignment extends Model { use HasComments,HasImage,HasCategories; protected $fillable=['course_id','title','description','due_at']; protected function casts(): array {return ['due_at'=>'datetime'];} public function course(){return $this->belongsTo(Course::class);} }
