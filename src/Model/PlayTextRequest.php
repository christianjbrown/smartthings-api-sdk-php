<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayTextRequest implements PlayTextRequestInterface
{
    private ?string $audioFormat = null;
    private string $deviceId;
    private ?string $engine = null;
    private string $languageCode;
    private ?string $speakingStyle = null;
    private string $text;
    private ?string $ttsProvider = null;
    private string $voiceId;
    private ?int $volume = null;

    public function __construct(string $deviceId, string $text, string $languageCode, string $voiceId)
    {
        $this->deviceId = $deviceId;
        $this->text = $text;
        $this->languageCode = $languageCode;
        $this->voiceId = $voiceId;
    }

    public function getAudioFormat(): ?string
    {
        return $this->audioFormat;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    public function getSpeakingStyle(): ?string
    {
        return $this->speakingStyle;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTtsProvider(): ?string
    {
        return $this->ttsProvider;
    }

    public function getVoiceId(): string
    {
        return $this->voiceId;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setAudioFormat(?string $value): PlayTextRequestInterface
    {
        $this->audioFormat = $value;

        return $this;
    }

    public function setEngine(?string $value): PlayTextRequestInterface
    {
        $this->engine = $value;

        return $this;
    }

    public function setSpeakingStyle(?string $value): PlayTextRequestInterface
    {
        $this->speakingStyle = $value;

        return $this;
    }

    public function setTtsProvider(?string $value): PlayTextRequestInterface
    {
        $this->ttsProvider = $value;

        return $this;
    }

    public function setVolume(?int $value): PlayTextRequestInterface
    {
        $this->volume = $value;

        return $this;
    }
}
