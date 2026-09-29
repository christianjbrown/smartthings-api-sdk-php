<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\VirtualDeviceDetails;
use ChristianBrown\SmartThings\Model\VirtualDeviceDetailsInterface;

use function is_array;
use function is_bool;
use function is_string;

final class VirtualDeviceDetailsTransformer implements VirtualDeviceDetailsTransformerInterface
{
    private CommandMappingsTransformerInterface $commandMappingsTransformer;

    public function __construct(CommandMappingsTransformerInterface $commandMappingsTransformer)
    {
        $this->commandMappingsTransformer = $commandMappingsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VirtualDeviceDetailsInterface
    {
        $model = new VirtualDeviceDetails();

        self::applyName($model, $data);
        self::applyHubId($model, $data);
        self::applyDriverId($model, $data);
        self::applyExecutingLocally($model, $data);
        $this->applyCommandMappings($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommandMappings(VirtualDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMAND_MAPPINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMAND_MAPPINGS])) {
            return;
        }
        $model->setCommandMappings($this->commandMappingsTransformer->transform($data[self::KEY_COMMAND_MAPPINGS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverId(VirtualDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            return;
        }
        $model->setDriverId($data[self::KEY_DRIVER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(VirtualDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        $model->setExecutingLocally($data[self::KEY_EXECUTING_LOCALLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubId(VirtualDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_HUB_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_HUB_ID])) {
            return;
        }
        $model->setHubId($data[self::KEY_HUB_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(VirtualDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }
}
