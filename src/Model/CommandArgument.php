<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandArgument implements CommandArgumentInterface
{
    private string $name;
    private ?bool $optional = null;

    /**
     * @var mixed[]
     */
    private array $schema;

    /**
     * @phpstan-param mixed[] $schema
     */
    public function __construct(string $name, array $schema)
    {
        $this->name = $name;
        $this->schema = $schema;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOptional(): ?bool
    {
        return $this->optional;
    }

    /**
     * @return mixed[]
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    public function setOptional(?bool $value): CommandArgumentInterface
    {
        $this->optional = $value;

        return $this;
    }
}
