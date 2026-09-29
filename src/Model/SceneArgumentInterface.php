<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneArgumentInterface
{
    public function getName(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getSchema(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array;

    public function setName(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setSchema(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): self;
}
