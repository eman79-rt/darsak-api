<?php
namespace App\Models;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use HasApiTokens,HasFactory,Notifiable; protected $fillable=['name','email','password','role']; protected $hidden=['password','remember_token']; protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','role'=>UserRole::class]; } public function courses(){return $this->hasMany(Course::class,'teacher_id');} public function enrollments(){return $this->hasMany(Enrollment::class,'student_id');} }
