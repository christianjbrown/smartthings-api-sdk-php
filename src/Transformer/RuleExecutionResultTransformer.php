<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleExecutionResult;
use ChristianBrown\SmartThings\Model\RuleExecutionResultInterface;

use function is_string;
use function sprintf;

final class RuleExecutionResultTransformer implements RuleExecutionResultTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RuleExecutionResultInterface
    {
        if (empty($data[self::KEY_EXECUTION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_EXECUTION_ID));
        }
        if (!is_string($data[self::KEY_EXECUTION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_EXECUTION_ID));
        }
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $result = new RuleExecutionResult($data[self::KEY_EXECUTION_ID], $data[self::KEY_ID]);

        self::applyResult($result, $data);

        return $result;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyResult(RuleExecutionResult $result, array $data): void
    {
        if (empty($data[self::KEY_RESULT])) {
            return;
        }
        if (!is_string($data[self::KEY_RESULT])) {
            return;
        }
        $result->setResult($data[self::KEY_RESULT]);
    }
}
