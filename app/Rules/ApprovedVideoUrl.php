<?php
namespace App\Rules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class ApprovedVideoUrl implements ValidationRule { public function validate(string $attribute,mixed $value,Closure $fail): void { $host=strtolower((string) parse_url($value,PHP_URL_HOST)); $allowed=['youtube.com','www.youtube.com','youtu.be','m.youtube.com','vimeo.com','www.vimeo.com','player.vimeo.com']; if (!in_array($host,$allowed,true)) $fail('يجب أن يكون رابط الفيديو من YouTube أو Vimeo.'); } }
