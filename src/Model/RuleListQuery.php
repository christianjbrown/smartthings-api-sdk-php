<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleListQuery implements RuleListQueryInterface
{
    private ?bool $includeAllParents = null;
    private ?int $max = null;
    private ?int $offset = null;

    public function getIncludeAllParents(): ?bool
    {
        return $this->includeAllParents;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_INCLUDE_ALL_PARENTS => $this->includeAllParents,
            self::KEY_MAX => $this->max,
            self::KEY_OFFSET => $this->offset,
        ];
    }

    public function setIncludeAllParents(?bool $value): RuleListQueryInterface
    {
        $this->includeAllParents = $value;

        return $this;
    }

    public function setMax(?int $value): RuleListQueryInterface
    {
        $this->max = $value;

        return $this;
    }

    public function setOffset(?int $value): RuleListQueryInterface
    {
        $this->offset = $value;

        return $this;
    }
}
