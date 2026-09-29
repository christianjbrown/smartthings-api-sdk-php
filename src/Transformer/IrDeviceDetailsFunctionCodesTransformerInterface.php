<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetailsFunctionCodesInterface;

interface IrDeviceDetailsFunctionCodesTransformerInterface
{
    public const string KEY_DEFAULT = 'default';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IrDeviceDetailsFunctionCodesInterface;
}
