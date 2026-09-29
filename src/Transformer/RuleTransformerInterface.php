<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RuleInterface;

interface RuleTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_CREATOR = 'creator';
    public const string KEY_DATE_CREATED = 'dateCreated';
    public const string KEY_DATE_UPDATED = 'dateUpdated';
    public const string KEY_EXECUTION_LOCATION = 'executionLocation';
    public const string KEY_ID = 'id';
    public const string KEY_NAME = 'name';
    public const string KEY_OWNER_ID = 'ownerId';
    public const string KEY_OWNER_TYPE = 'ownerType';
    public const string KEY_SEQUENCE = 'sequence';
    public const string KEY_STATUS = 'status';
    public const string KEY_TIME_ZONE_ID = 'timeZoneId';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RuleInterface;
}
