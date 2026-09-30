<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TtsVoice implements TtsVoiceInterface
{
    private ?string $gender;
    private ?string $id;
    private ?string $languageCode;
    private ?string $languageName;
    private ?string $name;

    /**
     * @var null|array<int, string>
     */
    private ?array $speakingStyle = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $supportedEngines = null;
    private ?string $ttsProvider;

    public function __construct(?string $gender, ?string $id, ?string $languageCode, ?string $languageName, ?string $name, ?string $ttsProvider)
    {
        $this->gender = $gender;
        $this->id = $id;
        $this->languageCode = $languageCode;
        $this->languageName = $languageName;
        $this->name = $name;
        $this->ttsProvider = $ttsProvider;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function getLanguageName(): ?string
    {
        return $this->languageName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return null|array<int, string>
     */
    public function getSpeakingStyle(): ?array
    {
        return $this->speakingStyle;
    }

    /**
     * @return null|array<int, string>
     */
    public function getSupportedEngines(): ?array
    {
        return $this->supportedEngines;
    }

    public function getTtsProvider(): ?string
    {
        return $this->ttsProvider;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setSpeakingStyle(?array $value): TtsVoiceInterface
    {
        $this->speakingStyle = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setSupportedEngines(?array $value): TtsVoiceInterface
    {
        $this->supportedEngines = $value;

        return $this;
    }
}
