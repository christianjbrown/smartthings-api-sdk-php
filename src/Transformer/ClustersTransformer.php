<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\Clusters;
use ChristianBrown\SmartThings\Model\ClustersInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_int;

final class ClustersTransformer implements ClustersTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ClustersInterface
    {
        $model = new Clusters();

        self::applyClient($model, $data);
        self::applyServer($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClient(Clusters $model, array $data): void
    {
        if (!isset($data[self::KEY_CLIENT])) {
            return;
        }
        if (!is_array($data[self::KEY_CLIENT])) {
            return;
        }
        $model->setClient(array_values(array_filter($data[self::KEY_CLIENT], is_int(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyServer(Clusters $model, array $data): void
    {
        if (!isset($data[self::KEY_SERVER])) {
            return;
        }
        if (!is_array($data[self::KEY_SERVER])) {
            return;
        }
        $model->setServer(array_values(array_filter($data[self::KEY_SERVER], is_int(...))));
    }
}
