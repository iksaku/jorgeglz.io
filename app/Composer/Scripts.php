<?php

namespace App\Composer;

use Composer\Script\Event;

class Scripts
{
    public static function devOnly(Event $event)
    {
        if (!$event->isDevMode()) {
            $event->stopPropagation();
        }
    }
}
