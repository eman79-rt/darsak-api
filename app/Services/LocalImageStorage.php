<?php
namespace App\Services;
use App\Contracts\ImageStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class LocalImageStorage implements ImageStorage { public function store(UploadedFile $file): string {return $file->store('images','public');} public function delete(string $path): void {Storage::disk('public')->delete($path);} }
