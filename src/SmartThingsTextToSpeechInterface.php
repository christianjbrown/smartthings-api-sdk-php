<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\TextToSpeechApiInterface;

interface SmartThingsTextToSpeechInterface
{
    public function getTextToSpeechApi(): TextToSpeechApiInterface;
}
