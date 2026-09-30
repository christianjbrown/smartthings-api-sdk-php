<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationListQuery implements LocationListQueryInterface
{
    private ?bool $allowed = null;
    private ?int $limit = null;
    private ?string $page = null;

    public function getAllowed(): ?bool
    {
        return $this->allowed;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_ALLOWED => $this->allowed,
            self::KEY_LIMIT => $this->limit,
            self::KEY_PAGE => $this->page,
        ];
    }

    public function setAllowed(?bool $value): LocationListQueryInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setLimit(?int $value): LocationListQueryInterface
    {
        $this->limit = $value;

        return $this;
    }

    public function setPage(?string $value): LocationListQueryInterface
    {
        $this->page = $value;

        return $this;
    }
}
