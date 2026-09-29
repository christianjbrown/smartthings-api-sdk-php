<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PlayTextRequestInterface
{
    public function getAudioFormat(): ?string;

    public function getDeviceId(): string;

    public function getEngine(): ?string;

    public function getLanguageCode(): string;

    public function getSpeakingStyle(): ?string;

    public function getText(): string;

    public function getTtsProvider(): ?string;

    public function getVoiceId(): string;

    public function getVolume(): ?int;

    public function setAudioFormat(?string $value): self;

    public function setEngine(?string $value): self;

    public function setSpeakingStyle(?string $value): self;

    public function setTtsProvider(?string $value): self;

    public function setVolume(?int $value): self;
}
