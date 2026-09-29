<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetails;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetailsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class ServiceCapabilityDataDetailsTransformer implements ServiceCapabilityDataDetailsTransformerInterface
{
    private ServiceCapabilityDataAlertItemTransformerInterface $serviceCapabilityDataAlertItemTransformer;

    public function __construct(ServiceCapabilityDataAlertItemTransformerInterface $serviceCapabilityDataAlertItemTransformer)
    {
        $this->serviceCapabilityDataAlertItemTransformer = $serviceCapabilityDataAlertItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataDetailsInterface
    {
        $model = new ServiceCapabilityDataDetails();

        $this->applyAlert($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlert(ServiceCapabilityDataDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ALERT])) {
            return;
        }
        if (!is_array($data[self::KEY_ALERT])) {
            return;
        }
        $model->setAlert($this->transformListServiceCapabilityDataAlertItem($data[self::KEY_ALERT]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ServiceCapabilityDataAlertItemInterface>
     */
    private function transformListServiceCapabilityDataAlertItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ServiceCapabilityDataAlertItemInterface => $this->serviceCapabilityDataAlertItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
