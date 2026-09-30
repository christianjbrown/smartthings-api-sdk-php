<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MessageConfig implements MessageConfigInterface
{
    private ?string $messageGroupKey = null;

    public function getMessageGroupKey(): ?string
    {
        return $this->messageGroupKey;
    }

    public function setMessageGroupKey(?string $value): MessageConfigInterface
    {
        $this->messageGroupKey = $value;

        return $this;
    }
}
