<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateSignatureTypeRequest implements UpdateSignatureTypeRequestInterface
{
    private string $signatureType;

    public function __construct(string $signatureType)
    {
        $this->signatureType = $signatureType;
    }

    public function getSignatureType(): string
    {
        return $this->signatureType;
    }
}
