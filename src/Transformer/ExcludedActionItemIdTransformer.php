<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedActionItemId;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function sprintf;

final class ExcludedActionItemIdTransformer implements ExcludedActionItemIdTransformerInterface
{
    private ExcludedActionItemIdExcludeItemTransformerInterface $excludedActionItemIdExcludeItemTransformer;

    public function __construct(ExcludedActionItemIdExcludeItemTransformerInterface $excludedActionItemIdExcludeItemTransformer)
    {
        $this->excludedActionItemIdExcludeItemTransformer = $excludedActionItemIdExcludeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedActionItemIdInterface
    {
        $model = new ExcludedActionItemId($this->requireExclude($data));

        self::applyId($model, $data);
        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(ExcludedActionItemId $model, array $data): void
    {
        if (!isset($data[self::KEY_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ExcludedActionItemId $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedActionItemIdExcludeItemInterface>
     */
    private function requireExclude(array $data): array
    {
        if (!isset($data[self::KEY_EXCLUDE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_EXCLUDE));
        }
        if (!is_array($data[self::KEY_EXCLUDE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_EXCLUDE));
        }

        return $this->transformListExcludedActionItemIdExcludeItem($data[self::KEY_EXCLUDE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedActionItemIdExcludeItemInterface>
     */
    private function transformListExcludedActionItemIdExcludeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedActionItemIdExcludeItemInterface => $this->excludedActionItemIdExcludeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
