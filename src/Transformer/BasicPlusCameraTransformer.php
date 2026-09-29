<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusCamera;
use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function sprintf;

final class BasicPlusCameraTransformer implements BasicPlusCameraTransformerInterface
{
    private BasicPlusCameraImageTransformerInterface $basicPlusCameraImageTransformer;
    private BasicPlusCameraOverlayIconsItemTransformerInterface $basicPlusCameraOverlayIconsItemTransformer;

    public function __construct(BasicPlusCameraImageTransformerInterface $basicPlusCameraImageTransformer, BasicPlusCameraOverlayIconsItemTransformerInterface $basicPlusCameraOverlayIconsItemTransformer)
    {
        $this->basicPlusCameraImageTransformer = $basicPlusCameraImageTransformer;
        $this->basicPlusCameraOverlayIconsItemTransformer = $basicPlusCameraOverlayIconsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusCameraInterface
    {
        $model = new BasicPlusCamera($this->requireImage($data));

        $this->applyOverlayIcons($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOverlayIcons(BasicPlusCamera $model, array $data): void
    {
        if (!isset($data[self::KEY_OVERLAY_ICONS])) {
            return;
        }
        if (!is_array($data[self::KEY_OVERLAY_ICONS])) {
            return;
        }
        $model->setOverlayIcons($this->transformListBasicPlusCameraOverlayIconsItem($data[self::KEY_OVERLAY_ICONS]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireImage(array $data): BasicPlusCameraImageInterface
    {
        if (!isset($data[self::KEY_IMAGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_IMAGE));
        }
        if (!is_array($data[self::KEY_IMAGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_IMAGE));
        }

        return $this->basicPlusCameraImageTransformer->transform($data[self::KEY_IMAGE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusCameraOverlayIconsItemInterface>
     */
    private function transformListBasicPlusCameraOverlayIconsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusCameraOverlayIconsItemInterface => $this->basicPlusCameraOverlayIconsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
