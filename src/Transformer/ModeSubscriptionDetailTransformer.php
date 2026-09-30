<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ModeSubscriptionDetail;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetailInterface;

use function is_string;

final class ModeSubscriptionDetailTransformer implements ModeSubscriptionDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ModeSubscriptionDetailInterface
    {
        $model = new ModeSubscriptionDetail(self::requireLocationId($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLocationId(array $data): ?string
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return null;
        }

        return $data[self::KEY_LOCATION_ID];
    }
}
