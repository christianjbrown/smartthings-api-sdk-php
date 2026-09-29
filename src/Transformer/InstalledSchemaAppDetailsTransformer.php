<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResultsInterface;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppDetails;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppDetailsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class InstalledSchemaAppDetailsTransformer implements InstalledSchemaAppDetailsTransformerInterface
{
    private DeviceResultsTransformerInterface $deviceResultsTransformer;
    private ViperAppLinksTransformerInterface $viperAppLinksTransformer;

    public function __construct(DeviceResultsTransformerInterface $deviceResultsTransformer, ViperAppLinksTransformerInterface $viperAppLinksTransformer)
    {
        $this->deviceResultsTransformer = $deviceResultsTransformer;
        $this->viperAppLinksTransformer = $viperAppLinksTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledSchemaAppDetailsInterface
    {
        $model = new InstalledSchemaAppDetails();

        $this->applyDevices($model, $data);
        $this->applyViperAppLinks($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDevices(InstalledSchemaAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return;
        }
        $model->setDevices($this->transformListDeviceResults($data[self::KEY_DEVICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyViperAppLinks(InstalledSchemaAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VIPER_APP_LINKS])) {
            return;
        }
        if (!is_array($data[self::KEY_VIPER_APP_LINKS])) {
            return;
        }
        $model->setViperAppLinks($this->viperAppLinksTransformer->transform($data[self::KEY_VIPER_APP_LINKS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceResultsInterface>
     */
    private function transformListDeviceResults(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceResultsInterface => $this->deviceResultsTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
