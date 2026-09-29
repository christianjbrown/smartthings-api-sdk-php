<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface NoticeInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getActions(): ?array;

    public function getBadgeUrl(): ?string;

    public function getCode(): ?string;

    public function getMessage(): ?string;

    /**
     * @param null|array<int, string> $value
     */
    public function setActions(?array $value): self;

    public function setBadgeUrl(?string $value): self;

    public function setCode(?string $value): self;

    public function setMessage(?string $value): self;
}
