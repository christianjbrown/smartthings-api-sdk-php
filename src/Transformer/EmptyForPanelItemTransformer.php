<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EmptyForPanelItem;
use ChristianBrown\SmartThings\Model\EmptyForPanelItemInterface;

use function is_string;

final class EmptyForPanelItemTransformer implements EmptyForPanelItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EmptyForPanelItemInterface
    {
        $model = new EmptyForPanelItem(self::requireSize($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSize(array $data): ?string
    {
        if (empty($data[self::KEY_SIZE])) {
            return null;
        }
        if (!is_string($data[self::KEY_SIZE])) {
            return null;
        }

        return $data[self::KEY_SIZE];
    }
}
