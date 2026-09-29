<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Notice implements NoticeInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $actions = null;
    private ?string $badgeUrl = null;
    private ?string $code = null;
    private ?string $message = null;

    /**
     * @return null|array<int, string>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    public function getBadgeUrl(): ?string
    {
        return $this->badgeUrl;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setActions(?array $value): NoticeInterface
    {
        $this->actions = $value;

        return $this;
    }

    public function setBadgeUrl(?string $value): NoticeInterface
    {
        $this->badgeUrl = $value;

        return $this;
    }

    public function setCode(?string $value): NoticeInterface
    {
        $this->code = $value;

        return $this;
    }

    public function setMessage(?string $value): NoticeInterface
    {
        $this->message = $value;

        return $this;
    }
}
