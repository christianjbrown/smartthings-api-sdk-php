<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionRequestInterface;

interface ServiceSubscriptionRequestSerializerInterface
{
    public const string KEY_CAPABILITIES = 'capabilities';
    public const string KEY_ISA_ID = 'isaId';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_PREDICATE = 'predicate';
    public const string KEY_TYPE = 'type';

    /**
     * @return mixed[]
     */
    public function serialize(ServiceSubscriptionRequestInterface $request): array;
}
