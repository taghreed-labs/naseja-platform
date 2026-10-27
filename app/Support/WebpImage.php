<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class WebpImage
{
    public static function save(UploadedFile $file, string $directory, int $maxSide): string
    {
        if (!extension_loaded('gd') || !function_exists('imagewebp')) {
            throw new RuntimeException('فعّل امتداد GD في PHP لتحويل الصور إلى WebP.');
        }

        $sourcePath = $file->getRealPath();
        $info = $sourcePath ? @getimagesize($sourcePath) : false;

        if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            throw new RuntimeException('صيغة الصورة غير مدعومة.');
        }

        $source = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($sourcePath),
        };

        if ($source === false) {
            throw new RuntimeException('تعذر قراءة الصورة.');
        }

        try {
            // تدوير صور الهاتف وفق بيانات EXIF إن كانت الإضافة متاحة.
            if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
                $exif = @exif_read_data($sourcePath);
                $orientation = (int) ($exif['Orientation'] ?? 1);
                if (in_array($orientation, [3, 6, 8], true)) {
                    $degrees = [3 => 180, 6 => 270, 8 => 90][$orientation];
                    $rotated = imagerotate($source, $degrees, 0);
                    if ($rotated !== false) {
                        imagedestroy($source);
                        $source = $rotated;
                    }
                }
            }

            $width = imagesx($source);
            $height = imagesy($source);
            $ratio = min(1, $maxSide / max($width, $height));
            $newWidth = max(1, (int) round($width * $ratio));
            $newHeight = max(1, (int) round($height * $ratio));
            $output = imagecreatetruecolor($newWidth, $newHeight);
            if ($output === false) {
                throw new RuntimeException('تعذر تجهيز الصورة.');
            }

            try {
                imagealphablending($output, false);
                imagesavealpha($output, true);
                $transparent = imagecolorallocatealpha($output, 0, 0, 0, 127);
                imagefill($output, 0, 0, $transparent);
                if (!imagecopyresampled($output, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height)) {
                    throw new RuntimeException('تعذر تصغير الصورة.');
                }

                ob_start();
                $converted = imagewebp($output, null, 78);
                $bytes = ob_get_clean();
                if (!$converted || !$bytes) {
                    throw new RuntimeException('تعذر تحويل الصورة إلى WebP.');
                }

                $path = trim($directory, '/') . '/' . Str::uuid() . '.webp';
                if (!Storage::disk('public')->put($path, $bytes)) {
                    throw new RuntimeException('تعذر حفظ الصورة.');
                }
                return $path;
            } finally {
                imagedestroy($output);
            }
        } finally {
            imagedestroy($source);
        }
    }
}
