<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneArgument implements SceneArgumentInterface
{
    private ?string $name = null;

    /**
     * @var null|mixed[]
     */
    private ?array $schema = null;

    /**
     * @var null|mixed[]
     */
    private ?array $value = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return null|mixed[]
     */
    public function getSchema(): ?array
    {
        return $this->schema;
    }

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setName(?string $value): SceneArgumentInterface
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setSchema(?array $value): SceneArgumentInterface
    {
        $this->schema = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): SceneArgumentInterface
    {
        $this->value = $value;

        return $this;
    }
}
