<?php

namespace Detit\Polipeople\Curations;

use Awcodes\Curator\Curations\CurationPreset;

class PolipeopleThumbnailPreset extends CurationPreset
{
    public function getKey(): string
    {
        return 'polipeoplethumbnail';
    }

    public function getLabel(): string
    {
        return 'People Thumbnail';
    }

    public function getWidth(): int
    {
        return 400;
    }

    public function getHeight(): int
    {
        return 300;
    }

    public function getFormat(): string
    {
        return 'webp';
    }

    public function getQuality(): int
    {
        return 60;
    }
}
