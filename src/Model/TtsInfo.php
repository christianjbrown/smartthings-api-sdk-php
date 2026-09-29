<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TtsInfo implements TtsInfoInterface
{
    /**
     * @var null|array<int, TtsVoiceInterface>
     */
    private ?array $voices = null;

    /**
     * @return null|array<int, TtsVoiceInterface>
     */
    public function getVoices(): ?array
    {
        return $this->voices;
    }

    /**
     * @param null|array<int, TtsVoiceInterface> $value
     */
    public function setVoices(?array $value): TtsInfoInterface
    {
        $this->voices = $value;

        return $this;
    }
}
