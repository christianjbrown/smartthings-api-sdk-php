<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetailsFunctionCodes;
use ChristianBrown\SmartThings\Model\IrDeviceDetailsFunctionCodesInterface;

use function is_string;

final class IrDeviceDetailsFunctionCodesTransformer implements IrDeviceDetailsFunctionCodesTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IrDeviceDetailsFunctionCodesInterface
    {
        $model = new IrDeviceDetailsFunctionCodes();

        self::applyDefault($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDefault(IrDeviceDetailsFunctionCodes $model, array $data): void
    {
        if (empty($data[self::KEY_DEFAULT])) {
            return;
        }
        if (!is_string($data[self::KEY_DEFAULT])) {
            return;
        }
        $model->setDefault($data[self::KEY_DEFAULT]);
    }
}
