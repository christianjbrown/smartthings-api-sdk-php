<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Rule;
use ChristianBrown\SmartThings\Model\RuleInterface;

use function is_array;
use function is_string;
use function sprintf;

final class RuleTransformer implements RuleTransformerInterface
{
    private ActionTransformerInterface $actionTransformer;

    public function __construct(ActionTransformerInterface $actionTransformer)
    {
        $this->actionTransformer = $actionTransformer;
    }

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

        $this->applyActions($rule, $data);
        $this->applySequence($rule, $data);
        self::applyTimeZoneId($rule, $data);
        self::applyExecutionLocation($rule, $data);
        self::applyOwnerId($rule, $data);
        self::applyOwnerType($rule, $data);
        self::applyCreator($rule, $data);
        self::applyDateCreated($rule, $data);
        self::applyDateUpdated($rule, $data);
        self::applyAllowed($rule, $data);

        return $rule;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(Rule $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->actionTransformer->transformAll($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAllowed(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_ALLOWED])) {
            return;
        }
        if (!is_string($data[self::KEY_ALLOWED])) {
            return;
        }
        $model->setAllowed($data[self::KEY_ALLOWED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreator(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_CREATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATOR])) {
            return;
        }
        $model->setCreator($data[self::KEY_CREATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateCreated(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_DATE_CREATED])) {
            return;
        }
        if (!is_string($data[self::KEY_DATE_CREATED])) {
            return;
        }
        $model->setDateCreated($data[self::KEY_DATE_CREATED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateUpdated(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_DATE_UPDATED])) {
            return;
        }
        if (!is_string($data[self::KEY_DATE_UPDATED])) {
            return;
        }
        $model->setDateUpdated($data[self::KEY_DATE_UPDATED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutionLocation(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_EXECUTION_LOCATION])) {
            return;
        }
        if (!is_string($data[self::KEY_EXECUTION_LOCATION])) {
            return;
        }
        $model->setExecutionLocation($data[self::KEY_EXECUTION_LOCATION]);
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
    private static function applyOwnerId(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_OWNER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER_ID])) {
            return;
        }
        $model->setOwnerId($data[self::KEY_OWNER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOwnerType(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_OWNER_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER_TYPE])) {
            return;
        }
        $model->setOwnerType($data[self::KEY_OWNER_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySequence(Rule $model, array $data): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence($this->actionTransformer->transformActionSequence($data[self::KEY_SEQUENCE]));
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

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeZoneId(Rule $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }
}
