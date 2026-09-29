<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TtsRequestInterface
{
    public function getAudioFormat(): ?string;

    public function getEngine(): ?string;

    public function getLanguageCode(): string;

    public function getSpeakingStyle(): ?string;

    public function getText(): string;

    public function getTtsProvider(): ?string;

    public function getVoiceId(): string;

    public function setAudioFormat(?string $value): self;

    public function setEngine(?string $value): self;

    public function setSpeakingStyle(?string $value): self;

    public function setTtsProvider(?string $value): self;
}
