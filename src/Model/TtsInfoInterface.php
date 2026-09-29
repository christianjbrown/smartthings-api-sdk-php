<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TtsInfoInterface
{
    /**
     * @return null|array<int, TtsVoiceInterface>
     */
    public function getVoices(): ?array;

    /**
     * @param null|array<int, TtsVoiceInterface> $value
     */
    public function setVoices(?array $value): self;
}
