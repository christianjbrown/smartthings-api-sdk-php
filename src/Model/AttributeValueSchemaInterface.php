<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeValueSchemaInterface
{
    /**
     * @return null|mixed[]
     */
    public function getAdditionalKeywords(): ?array;

    /**
     * @return null|array<int, string>
     */
    public function getEnum(): ?array;

    public function getType(): ?string;

    /**
     * @param null|mixed[] $value
     */
    public function setAdditionalKeywords(?array $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setEnum(?array $value): self;

    public function setType(?string $value): self;
}
