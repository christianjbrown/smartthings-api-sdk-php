<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItem;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;

use function is_array;
use function is_string;
use function sprintf;

final class VisibleConditionForColorItemTransformer implements VisibleConditionForColorItemTransformerInterface
{
    private VisibleConditionForColorItemReferToTransformerInterface $visibleConditionForColorItemReferToTransformer;

    public function __construct(VisibleConditionForColorItemReferToTransformerInterface $visibleConditionForColorItemReferToTransformer)
    {
        $this->visibleConditionForColorItemReferToTransformer = $visibleConditionForColorItemReferToTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForColorItemInterface
    {
        $model = new VisibleConditionForColorItem(self::requireOperator($data), self::requireOperand($data));

        $this->applyReferTo($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReferTo(VisibleConditionForColorItem $model, array $data): void
    {
        if (!isset($data[self::KEY_REFER_TO])) {
            return;
        }
        if (!is_array($data[self::KEY_REFER_TO])) {
            return;
        }
        $model->setReferTo($this->visibleConditionForColorItemReferToTransformer->transform($data[self::KEY_REFER_TO]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperand(array $data): string
    {
        if (empty($data[self::KEY_OPERAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERAND));
        }
        if (!is_string($data[self::KEY_OPERAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERAND));
        }

        return $data[self::KEY_OPERAND];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperator(array $data): string
    {
        if (empty($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }

        return $data[self::KEY_OPERATOR];
    }
}
