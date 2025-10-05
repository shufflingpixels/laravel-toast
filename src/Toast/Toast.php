<?php

namespace ShufflingPixels\Toast;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ShufflingPixels\Toast\Message;
use ShufflingPixels\Toast\Severity;

/**
 * @method static Message new(Severity $severity, string $text, ?string $details = null, int $duration = 3000)
 * @method static Message info(string $text, ?string $details = null, int $duration = 3000)
 * @method static Message success(string $text, ?string $details = null, int $duration = 3000)
 * @method static Message warning(string $text, ?string $details = null, int $duration = 3000)
 * @method static Message error(string $text, ?string $details = null, int $duration = 3000)
 * @method static void flash(Message $message)
 * @method static Collection<int, Message> getFlashMessages()
 * @method static Collection<int, Message> getMessages()
 */
class Toast extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shufflingpixels.toast';
    }
}
