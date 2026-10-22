<?php
namespace App\Contracts;
use Illuminate\Http\UploadedFile;
interface ImageStorage { public function store(UploadedFile $file): string; public function delete(string $path): void; }
