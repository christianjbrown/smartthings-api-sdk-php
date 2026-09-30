<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PreferenceListQuery implements PreferenceListQueryInterface
{
    private ?string $namespace = null;
    private ?int $pageSize = null;
    private ?string $startKey = null;

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_NAMESPACE => $this->namespace,
            self::KEY_PAGE_SIZE => $this->pageSize,
            self::KEY_START_KEY => $this->startKey,
        ];
    }

    public function getStartKey(): ?string
    {
        return $this->startKey;
    }

    public function setNamespace(?string $value): PreferenceListQueryInterface
    {
        $this->namespace = $value;

        return $this;
    }

    public function setPageSize(?int $value): PreferenceListQueryInterface
    {
        $this->pageSize = $value;

        return $this;
    }

    public function setStartKey(?string $value): PreferenceListQueryInterface
    {
        $this->startKey = $value;

        return $this;
    }
}
