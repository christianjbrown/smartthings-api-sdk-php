<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PatchItem implements PatchItemInterface
{
    private ?string $op;
    private ?string $path;

    /**
     * @var null|mixed[]
     */
    private ?array $value = null;

    public function __construct(?string $op, ?string $path)
    {
        $this->op = $op;
        $this->path = $path;
    }

    public function getOp(): ?string
    {
        return $this->op;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): PatchItemInterface
    {
        $this->value = $value;

        return $this;
    }
}
