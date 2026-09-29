<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TtsRequest implements TtsRequestInterface
{
    private ?string $audioFormat = null;
    private ?string $engine = null;
    private string $languageCode;
    private ?string $speakingStyle = null;
    private string $text;
    private ?string $ttsProvider = null;
    private string $voiceId;

    public function __construct(string $text, string $languageCode, string $voiceId)
    {
        $this->text = $text;
        $this->languageCode = $languageCode;
        $this->voiceId = $voiceId;
    }

    public function getAudioFormat(): ?string
    {
        return $this->audioFormat;
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

    public function setAudioFormat(?string $value): TtsRequestInterface
    {
        $this->audioFormat = $value;

        return $this;
    }

    public function setEngine(?string $value): TtsRequestInterface
    {
        $this->engine = $value;

        return $this;
    }

    public function setSpeakingStyle(?string $value): TtsRequestInterface
    {
        $this->speakingStyle = $value;

        return $this;
    }

    public function setTtsProvider(?string $value): TtsRequestInterface
    {
        $this->ttsProvider = $value;

        return $this;
    }
}
