<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ConvertedTts implements ConvertedTtsInterface
{
    private string $audioUrl;
    private string $message;

    public function __construct(string $message, string $audioUrl)
    {
        $this->message = $message;
        $this->audioUrl = $audioUrl;
    }

    public function getAudioUrl(): string
    {
        return $this->audioUrl;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
