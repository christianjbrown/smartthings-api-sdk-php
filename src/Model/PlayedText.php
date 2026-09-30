<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayedText implements PlayedTextInterface
{
    private ?string $message;

    public function __construct(?string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
