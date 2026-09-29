<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

interface DeviceProfileTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_RESTRICTIONS, self::KEY_PREFERENCES, self::KEY_COMPONENTS];
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_ID = 'id';
    public const string KEY_METADATA = 'metadata';
    public const string KEY_MIGRATION_STATUS = 'migrationStatus';
    public const string KEY_NAME = 'name';
    public const string KEY_PREFERENCES = 'preferences';
    public const string KEY_PRESENTATION_ID = 'presentationId';
    public const string KEY_RESTRICTIONS = 'restrictions';
    public const string KEY_STATUS = 'status';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileInterface;
}
