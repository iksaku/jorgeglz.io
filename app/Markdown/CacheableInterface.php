<?php

namespace App\Markdown;

interface CacheableInterface
{
    public function getCacheKey(): string;

    public function getContent(): string;
}
