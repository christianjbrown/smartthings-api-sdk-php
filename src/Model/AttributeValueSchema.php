<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeValueSchema implements AttributeValueSchemaInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $additionalKeywords = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $enum = null;
    private ?string $type = null;

    /**
     * @return null|mixed[]
     */
    public function getAdditionalKeywords(): ?array
    {
        return $this->additionalKeywords;
    }

    /**
     * @return null|array<int, string>
     */
    public function getEnum(): ?array
    {
        return $this->enum;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setAdditionalKeywords(?array $value): AttributeValueSchemaInterface
    {
        $this->additionalKeywords = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setEnum(?array $value): AttributeValueSchemaInterface
    {
        $this->enum = $value;

        return $this;
    }

    public function setType(?string $value): AttributeValueSchemaInterface
    {
        $this->type = $value;

        return $this;
    }
}
