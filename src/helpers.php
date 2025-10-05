<?php

use ShufflingPixels\Toast\Severity;
use ShufflingPixels\Toast\Manager;

if (!function_exists('toast')) {
    function toast(?Severity $severity = null, ?string $text = null, ?string $details = null, int $duration = 3000): Manager {
        $toast = app('shufflingpixels.toast');
        if ($severity !== null && $text !== null) {
            $toast->new($severity, $text, $details, $duration);
        }
        return $toast;
    }
}
