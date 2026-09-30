<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicList;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;

use function is_array;
use function is_string;

final class SupportedValuesForDynamicListTransformer implements SupportedValuesForDynamicListTransformerInterface
{
    private SupportedValuesForDynamicListValueMapTransformerInterface $supportedValuesForDynamicListValueMapTransformer;

    public function __construct(SupportedValuesForDynamicListValueMapTransformerInterface $supportedValuesForDynamicListValueMapTransformer)
    {
        $this->supportedValuesForDynamicListValueMapTransformer = $supportedValuesForDynamicListValueMapTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SupportedValuesForDynamicListInterface
    {
        $model = new SupportedValuesForDynamicList(self::requireValue($data));

        $this->applyValueMap($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyValueMap(SupportedValuesForDynamicList $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE_MAP])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE_MAP])) {
            return;
        }
        $model->setValueMap($this->supportedValuesForDynamicListValueMapTransformer->transform($data[self::KEY_VALUE_MAP]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
        }

        return $data[self::KEY_VALUE];
    }
}
