<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetailsInterface;

interface IrDeviceDetailsTransformerInterface
{
    public const string KEY_CHILD_DEVICES = 'childDevices';
    public const string KEY_FUNCTION_CODES = 'functionCodes';
    public const string KEY_IR_CODE = 'irCode';
    public const string KEY_METADATA = 'metadata';
    public const string KEY_OCF_DEVICE_TYPE = 'ocfDeviceType';
    public const string KEY_PARENT_DEVICE_ID = 'parentDeviceId';
    public const string KEY_PROFILE_ID = 'profileId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IrDeviceDetailsInterface;
}
