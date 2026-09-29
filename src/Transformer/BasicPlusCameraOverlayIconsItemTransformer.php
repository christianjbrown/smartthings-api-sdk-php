<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItem;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;

use function is_array;
use function is_string;
use function sprintf;

final class BasicPlusCameraOverlayIconsItemTransformer implements BasicPlusCameraOverlayIconsItemTransformerInterface
{
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusCameraOverlayIconsItemInterface
    {
        $model = new BasicPlusCameraOverlayIconsItem(self::requireIconUrl($data));

        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(BasicPlusCameraOverlayIconsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireIconUrl(array $data): string
    {
        if (empty($data[self::KEY_ICON_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ICON_URL));
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ICON_URL));
        }

        return $data[self::KEY_ICON_URL];
    }
}
