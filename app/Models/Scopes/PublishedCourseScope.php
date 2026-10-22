<?php
namespace App\Models\Scopes;
use App\Enums\UserRole;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
class PublishedCourseScope implements Scope { public function apply(Builder $builder, Model $model): void { $user=auth()->user(); if (!$user || $user->role !== UserRole::Teacher) $builder->where($model->qualifyColumn('status'),CourseStatus::Published->value); } }
