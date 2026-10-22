<?php

namespace App\Providers;

use App\Contracts\ImageStorage;
use App\Services\LocalImageStorage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageStorage::class, LocalImageStorage::class);
    }

    public function boot(): void
    {
        Relation::enforceMorphMap(['course'=>\App\Models\Course::class,'lesson'=>\App\Models\Lesson::class,'assignment'=>\App\Models\Assignment::class]);
    }
}
