<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ConvertedTtsInterface
{
    public function getAudioUrl(): ?string;

    public function getMessage(): ?string;
}
