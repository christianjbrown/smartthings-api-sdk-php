<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetails;
use ChristianBrown\SmartThings\Model\IrDeviceDetailsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class IrDeviceDetailsTransformer implements IrDeviceDetailsTransformerInterface
{
    private IrDeviceDetailsFunctionCodesTransformerInterface $irDeviceDetailsFunctionCodesTransformer;

    public function __construct(IrDeviceDetailsFunctionCodesTransformerInterface $irDeviceDetailsFunctionCodesTransformer)
    {
        $this->irDeviceDetailsFunctionCodesTransformer = $irDeviceDetailsFunctionCodesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IrDeviceDetailsInterface
    {
        $model = new IrDeviceDetails();

        self::applyParentDeviceId($model, $data);
        self::applyProfileId($model, $data);
        self::applyOcfDeviceType($model, $data);
        self::applyIrCode($model, $data);
        $this->applyFunctionCodes($model, $data);
        $this->applyChildDevices($model, $data);
        self::applyMetadata($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyChildDevices(IrDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_CHILD_DEVICES])) {
            return;
        }
        if (!is_array($data[self::KEY_CHILD_DEVICES])) {
            return;
        }
        $model->setChildDevices($this->transformListIrDeviceDetails($data[self::KEY_CHILD_DEVICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFunctionCodes(IrDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_FUNCTION_CODES])) {
            return;
        }
        if (!is_array($data[self::KEY_FUNCTION_CODES])) {
            return;
        }
        $model->setFunctionCodes($this->irDeviceDetailsFunctionCodesTransformer->transform($data[self::KEY_FUNCTION_CODES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIrCode(IrDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_IR_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_IR_CODE])) {
            return;
        }
        $model->setIrCode($data[self::KEY_IR_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMetadata(IrDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_METADATA])) {
            return;
        }
        if (!is_array($data[self::KEY_METADATA])) {
            return;
        }
        $model->setMetadata($data[self::KEY_METADATA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOcfDeviceType(IrDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_OCF_DEVICE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_OCF_DEVICE_TYPE])) {
            return;
        }
        $model->setOcfDeviceType($data[self::KEY_OCF_DEVICE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyParentDeviceId(IrDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PARENT_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PARENT_DEVICE_ID])) {
            return;
        }
        $model->setParentDeviceId($data[self::KEY_PARENT_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProfileId(IrDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PROFILE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PROFILE_ID])) {
            return;
        }
        $model->setProfileId($data[self::KEY_PROFILE_ID]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, IrDeviceDetailsInterface>
     */
    private function transformListIrDeviceDetails(array $data): array
    {
        return array_values(array_map(fn (array $item): IrDeviceDetailsInterface => $this->transform($item), array_filter($data, is_array(...))));
    }
}
