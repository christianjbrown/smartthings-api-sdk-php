<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * A preference's definition follows its own schema per preferenceType (minimum/
 * maximum for integer/number, minLength/maxLength/stringType for string, options
 * for enumeration, and a default valid for any type). Modeling every variant as its
 * own typed class would add several classes for one small, loosely-typed object, so
 * it is accepted here as a raw array shaped per the vendor's schema
 * (https://developer.smartthings.com/docs/api/public/#operation/createPreference)
 * and passed through to the API unmodified. Used for both create and update
 * requests: the vendor spec uses the same PreferenceRequest schema for both.
 */
interface PreferenceRequestInterface
{
    /**
     * @return mixed[]
     */
    public function getDefinition(): array;

    public function getDefinitionModel(): ?PreferenceDefinitionInterface;

    public function getDescription(): ?string;

    public function getExplicit(): ?bool;

    public function getName(): string;

    public function getPreferenceId(): ?string;

    public function getPreferenceType(): string;

    public function getRequired(): ?bool;

    public function getTitle(): string;

    public function setDefinitionModel(?PreferenceDefinitionInterface $value): self;

    public function setDescription(?string $value): self;

    public function setExplicit(?bool $value): self;

    public function setPreferenceId(?string $value): self;

    public function setRequired(?bool $value): self;
}
