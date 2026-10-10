<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use App\Traits\UploadImage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use AddEdit, Logs, UploadImage;

    function get_dominant_colors(string $image_path, int $num_colors = 5): array
    {
        // Загружаем изображение
        $image = imagecreatefromstring(file_get_contents($image_path));
        if (!$image) {
            return [];
        }

        // Уменьшаем размер для ускорения (макс 200px по ширине)
        $width   = imagesx($image);
        $height  = imagesy($image);
        $maxSize = 200;

        if ($width > $maxSize) {
            $newWidth  = $maxSize;
            $newHeight = (int)($height * ($maxSize / $width));
            $resized   = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image  = $resized;
            $width  = $newWidth;
            $height = $newHeight;
        }

        // Собираем все пиксели
        $pixels = [];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $r   = ($rgb >> 16) & 0xFF;
                $g   = ($rgb >> 8) & 0xFF;
                $b   = $rgb & 0xFF;

                // Округляем цвет до ближайшего "кванта" (уменьшаем количество уникальных цветов)
                $quant = 32; // шаг квантования (16, 32, 64)
                $key   = floor($r / $quant) . ',' . floor($g / $quant) . ',' . floor($b / $quant);

                if (!isset($pixels[$key])) {
                    $pixels[$key] = 0;
                }
                $pixels[$key]++;
            }
        }

        // Сортируем по частоте
        arsort($pixels);

        // Берём топ N цветов
        $totalPixels = $width * $height;
        $colors      = [];
        $i           = 0;
        foreach ($pixels as $key => $count) {
            if ($i >= $num_colors) break;

            list($r, $g, $b) = explode(',', $key);
            $r = (int)$r * $quant + ($quant / 2);
            $g = (int)$g * $quant + ($quant / 2);
            $b = (int)$b * $quant + ($quant / 2);

            $colors[] = [
                'rgb'        => [
                    $r,
                    $g,
                    $b
                ],
                'hex'        => sprintf('#%02x%02x%02x', $r, $g, $b),
                'percentage' => round($count / $totalPixels * 100, 1)
            ];
            $i++;
        }

        imagedestroy($image);
        return $colors;

        // TODO Пример использования
        $colors = getDominantColors('ocean.jpg', 5);
        foreach ($colors as $color) {
            echo "{$color['hex']} — {$color['percentage']}%\n";
        }
    }
}
