<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CoordinateAliasRequestInterface
{
    public function getLatitude(): float;

    public function getLongitude(): float;

    public function getRegionRadius(): int;
}
