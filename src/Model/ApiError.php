<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ApiError implements ApiErrorInterface
{
    private ?string $code = null;

    /**
     * @var array<int, ApiErrorInterface>
     */
    private array $details = [];
    private ?string $message = null;
    private ?string $target = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return array<int, ApiErrorInterface>
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setCode(?string $value): ApiErrorInterface
    {
        $this->code = $value;

        return $this;
    }

    /**
     * @param array<int, ApiErrorInterface> $value
     */
    public function setDetails(array $value): ApiErrorInterface
    {
        $this->details = $value;

        return $this;
    }

    public function setMessage(?string $value): ApiErrorInterface
    {
        $this->message = $value;

        return $this;
    }

    public function setTarget(?string $value): ApiErrorInterface
    {
        $this->target = $value;

        return $this;
    }
}
