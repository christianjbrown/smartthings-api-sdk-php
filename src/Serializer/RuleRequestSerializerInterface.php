<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\RuleRequestInterface;

interface RuleRequestSerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_NAME = 'name';
    public const string KEY_SEQUENCE = 'sequence';
    public const string KEY_TIME_ZONE_ID = 'timeZoneId';

    /**
     * @return mixed[]
     */
    public function serialize(RuleRequestInterface $request): array;
}
