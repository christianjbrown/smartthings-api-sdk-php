<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TtsVoiceInterface
{
    public function getGender(): string;

    public function getId(): string;

    public function getLanguageCode(): string;

    public function getLanguageName(): string;

    public function getName(): string;

    /**
     * @return null|array<int, string>
     */
    public function getSpeakingStyle(): ?array;

    /**
     * @return null|array<int, string>
     */
    public function getSupportedEngines(): ?array;

    public function getTtsProvider(): string;

    /**
     * @param null|array<int, string> $value
     */
    public function setSpeakingStyle(?array $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setSupportedEngines(?array $value): self;
}
