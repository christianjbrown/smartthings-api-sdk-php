<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IdLessHealthState;
use ChristianBrown\SmartThings\Model\IdLessHealthStateInterface;

use function is_string;

final class IdLessHealthStateTransformer implements IdLessHealthStateTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IdLessHealthStateInterface
    {
        $model = new IdLessHealthState();

        self::applyState($model, $data);
        self::applyLastUpdatedDate($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastUpdatedDate(IdLessHealthState $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_UPDATED_DATE])) {
            return;
        }
        $model->setLastUpdatedDate($data[self::KEY_LAST_UPDATED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyState(IdLessHealthState $model, array $data): void
    {
        if (empty($data[self::KEY_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($data[self::KEY_STATE]);
    }
}
