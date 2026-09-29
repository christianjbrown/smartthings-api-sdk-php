<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterDeviceDetails;
use ChristianBrown\SmartThings\Model\MatterDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\MatterEndpointInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class MatterDeviceDetailsTransformer implements MatterDeviceDetailsTransformerInterface
{
    private MatterEndpointTransformerInterface $matterEndpointTransformer;
    private MatterVersionTransformerInterface $matterVersionTransformer;

    public function __construct(MatterVersionTransformerInterface $matterVersionTransformer, MatterEndpointTransformerInterface $matterEndpointTransformer)
    {
        $this->matterVersionTransformer = $matterVersionTransformer;
        $this->matterEndpointTransformer = $matterEndpointTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterDeviceDetailsInterface
    {
        $model = new MatterDeviceDetails();

        self::applyDriverId($model, $data);
        self::applyHubId($model, $data);
        self::applyProvisioningState($model, $data);
        self::applyNetworkId($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyUniqueId($model, $data);
        self::applyVendorId($model, $data);
        self::applyProductId($model, $data);
        self::applySerialNumber($model, $data);
        self::applyListeningType($model, $data);
        self::applySupportedNetworkInterfaces($model, $data);
        $this->applyVersion($model, $data);
        $this->applyEndpoints($model, $data);
        self::applySyncDrivers($model, $data);
        self::applyFingerprintType($model, $data);
        self::applyFingerprintId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverId(MatterDeviceDetails $model, array $data): void
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
    private function applyEndpoints(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ENDPOINTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ENDPOINTS])) {
            return;
        }
        $model->setEndpoints($this->transformListMatterEndpoint($data[self::KEY_ENDPOINTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(MatterDeviceDetails $model, array $data): void
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
    private static function applyFingerprintId(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_FINGERPRINT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_FINGERPRINT_ID])) {
            return;
        }
        $model->setFingerprintId($data[self::KEY_FINGERPRINT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFingerprintType(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_FINGERPRINT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_FINGERPRINT_TYPE])) {
            return;
        }
        $model->setFingerprintType($data[self::KEY_FINGERPRINT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubId(MatterDeviceDetails $model, array $data): void
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
    private static function applyListeningType(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_LISTENING_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_LISTENING_TYPE])) {
            return;
        }
        $model->setListeningType($data[self::KEY_LISTENING_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyNetworkId(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_NETWORK_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_NETWORK_ID])) {
            return;
        }
        $model->setNetworkId($data[self::KEY_NETWORK_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProductId(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_PRODUCT_ID])) {
            return;
        }
        $model->setProductId($data[self::KEY_PRODUCT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyProvisioningState(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_PROVISIONING_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_PROVISIONING_STATE])) {
            return;
        }
        $model->setProvisioningState($data[self::KEY_PROVISIONING_STATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySerialNumber(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        $model->setSerialNumber($data[self::KEY_SERIAL_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedNetworkInterfaces(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_SUPPORTED_NETWORK_INTERFACES])) {
            return;
        }
        if (!is_array($data[self::KEY_SUPPORTED_NETWORK_INTERFACES])) {
            return;
        }
        $model->setSupportedNetworkInterfaces(array_values(array_filter($data[self::KEY_SUPPORTED_NETWORK_INTERFACES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySyncDrivers(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_SYNC_DRIVERS])) {
            return;
        }
        if (!is_bool($data[self::KEY_SYNC_DRIVERS])) {
            return;
        }
        $model->setSyncDrivers($data[self::KEY_SYNC_DRIVERS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUniqueId(MatterDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_UNIQUE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIQUE_ID])) {
            return;
        }
        $model->setUniqueId($data[self::KEY_UNIQUE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVendorId(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VENDOR_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_VENDOR_ID])) {
            return;
        }
        $model->setVendorId($data[self::KEY_VENDOR_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVersion(MatterDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_array($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($this->matterVersionTransformer->transform($data[self::KEY_VERSION]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, MatterEndpointInterface>
     */
    private function transformListMatterEndpoint(array $data): array
    {
        return array_values(array_map(fn (array $item): MatterEndpointInterface => $this->matterEndpointTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
