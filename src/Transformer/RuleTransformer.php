<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Rule;
use ChristianBrown\SmartThings\Model\RuleInterface;

use function is_string;
use function sprintf;

final class RuleTransformer implements RuleTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RuleInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $rule = new Rule($data[self::KEY_ID]);

        self::applyName($rule, $data);
        self::applyStatus($rule, $data);

        return $rule;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Rule $rule, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $rule->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(Rule $rule, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $rule->setStatus($data[self::KEY_STATUS]);
    }
}
