<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequestInterface;

interface UpdateSignatureTypeRequestSerializerInterface
{
    public const string KEY_SIGNATURE_TYPE = 'signatureType';

    /**
     * @return mixed[]
     */
    public function serialize(UpdateSignatureTypeRequestInterface $request): array;
}
