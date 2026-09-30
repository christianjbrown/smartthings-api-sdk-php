<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ErrorResponse implements ErrorResponseInterface
{
    private ?ApiErrorInterface $error = null;
    private ?string $requestId = null;

    public function getError(): ?ApiErrorInterface
    {
        return $this->error;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function setError(?ApiErrorInterface $value): ErrorResponseInterface
    {
        $this->error = $value;

        return $this;
    }

    public function setRequestId(?string $value): ErrorResponseInterface
    {
        $this->requestId = $value;

        return $this;
    }
}
