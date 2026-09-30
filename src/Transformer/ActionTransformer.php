<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\Action;
use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequence;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\ArrayOperand;
use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\BetweenCondition;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ChangesCondition;
use ChristianBrown\SmartThings\Model\ChangesConditionInterface;
use ChristianBrown\SmartThings\Model\CommandAction;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\CommandSequence;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;
use ChristianBrown\SmartThings\Model\Condition;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\DateOperand;
use ChristianBrown\SmartThings\Model\DateOperandInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperand;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\DeviceOperand;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;
use ChristianBrown\SmartThings\Model\EqualsCondition;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\EveryAction;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanCondition;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsCondition;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\IfAction;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\IfActionSequence;
use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;
use ChristianBrown\SmartThings\Model\Interval;
use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\LessThanCondition;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsCondition;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\LimitAction;
use ChristianBrown\SmartThings\Model\LimitActionInterface;
use ChristianBrown\SmartThings\Model\LocationAction;
use ChristianBrown\SmartThings\Model\LocationActionInterface;
use ChristianBrown\SmartThings\Model\LocationOperand;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;
use ChristianBrown\SmartThings\Model\Operand;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\RemainsCondition;
use ChristianBrown\SmartThings\Model\RemainsConditionInterface;
use ChristianBrown\SmartThings\Model\RuleDeviceCommand;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;
use ChristianBrown\SmartThings\Model\SceneAction;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SceneArgument;
use ChristianBrown\SmartThings\Model\SceneArgumentInterface;
use ChristianBrown\SmartThings\Model\SceneCapability;
use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneCommand;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;
use ChristianBrown\SmartThings\Model\SceneComponent;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequest;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequest;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;
use ChristianBrown\SmartThings\Model\SceneModeRequest;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;
use ChristianBrown\SmartThings\Model\SceneSleepRequest;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;
use ChristianBrown\SmartThings\Model\SleepAction;
use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Model\TimeOperand;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;
use ChristianBrown\SmartThings\Model\ToggleAction;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;
use ChristianBrown\SmartThings\Model\WasCondition;
use ChristianBrown\SmartThings\Model\WasConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_numeric;
use function is_string;

final class ActionTransformer implements ActionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionInterface
    {
        return self::toAction($data);
    }

    /**
     * @param mixed[] $data
     */
    public function transformActionSequence(array $data): ActionSequenceInterface
    {
        return self::toActionSequence($data);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    public function transformAll(array $data): array
    {
        return self::toActionList($data);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionSequenceInterface>
     */
    public function transformAllActionSequence(array $data): array
    {
        return self::toActionSequenceList($data);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionInterface>
     */
    public function transformMap(array $data): array
    {
        return self::toActionMap($data);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionSequenceInterface>
     */
    public function transformMapActionSequence(array $data): array
    {
        return self::toActionSequenceMap($data);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionCommand(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return;
        }
        $model->setCommand(self::toCommandAction($data[self::KEY_COMMAND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionEvery(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_EVERY])) {
            return;
        }
        if (!is_array($data[self::KEY_EVERY])) {
            return;
        }
        $model->setEvery(self::toEveryAction($data[self::KEY_EVERY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionIf(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_IF])) {
            return;
        }
        if (!is_array($data[self::KEY_IF])) {
            return;
        }
        $model->setIf(self::toIfAction($data[self::KEY_IF]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionLimit(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_LIMIT])) {
            return;
        }
        if (!is_array($data[self::KEY_LIMIT])) {
            return;
        }
        $model->setLimit(self::toLimitAction($data[self::KEY_LIMIT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionLocation(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $model->setLocation(self::toLocationAction($data[self::KEY_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionScene(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_SCENE])) {
            return;
        }
        if (!is_array($data[self::KEY_SCENE])) {
            return;
        }
        $model->setScene(self::toSceneAction($data[self::KEY_SCENE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionSequenceActions(ActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($data[self::KEY_ACTIONS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionSleep(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_SLEEP])) {
            return;
        }
        if (!is_array($data[self::KEY_SLEEP])) {
            return;
        }
        $model->setSleep(self::toSleepAction($data[self::KEY_SLEEP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActionToggle(Action $model, array $data): void
    {
        if (!isset($data[self::KEY_TOGGLE])) {
            return;
        }
        if (!is_array($data[self::KEY_TOGGLE])) {
            return;
        }
        $model->setToggle(self::toToggleAction($data[self::KEY_TOGGLE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArrayOperandAggregation(ArrayOperand $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBetweenConditionAggregation(BetweenCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBetweenConditionChangesOnly(BetweenCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionAnd(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionBetween(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween(self::toBetweenCondition($data[self::KEY_BETWEEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionEquals(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals(self::toEqualsCondition($data[self::KEY_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionGreaterThan(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan(self::toGreaterThanCondition($data[self::KEY_GREATER_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionGreaterThanOrEquals(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals(self::toGreaterThanOrEqualsCondition($data[self::KEY_GREATER_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionLessThan(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan(self::toLessThanCondition($data[self::KEY_LESS_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionLessThanOrEquals(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals(self::toLessThanOrEqualsCondition($data[self::KEY_LESS_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionNot(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot(self::toCondition($data[self::KEY_NOT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionOperand(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OPERAND])) {
            return;
        }
        if (!is_array($data[self::KEY_OPERAND])) {
            return;
        }
        $model->setOperand(self::toOperand($data[self::KEY_OPERAND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChangesConditionOr(ChangesCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommandActionSequence(CommandAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence(self::toCommandSequence($data[self::KEY_SEQUENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommandSequenceCommands(CommandSequence $model, array $data): void
    {
        if (empty($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands($data[self::KEY_COMMANDS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommandSequenceDevices(CommandSequence $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICES])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICES])) {
            return;
        }
        $model->setDevices($data[self::KEY_DEVICES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionAnd(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionBetween(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween(self::toBetweenCondition($data[self::KEY_BETWEEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionChanges(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES])) {
            return;
        }
        if (!is_array($data[self::KEY_CHANGES])) {
            return;
        }
        $model->setChanges(self::toChangesCondition($data[self::KEY_CHANGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionEquals(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals(self::toEqualsCondition($data[self::KEY_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionGreaterThan(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan(self::toGreaterThanCondition($data[self::KEY_GREATER_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionGreaterThanOrEquals(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals(self::toGreaterThanOrEqualsCondition($data[self::KEY_GREATER_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionLessThan(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan(self::toLessThanCondition($data[self::KEY_LESS_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionLessThanOrEquals(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals(self::toLessThanOrEqualsCondition($data[self::KEY_LESS_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionNot(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot(self::toCondition($data[self::KEY_NOT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionOr(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionRemains(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_REMAINS])) {
            return;
        }
        if (!is_array($data[self::KEY_REMAINS])) {
            return;
        }
        $model->setRemains(self::toRemainsCondition($data[self::KEY_REMAINS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionWas(Condition $model, array $data): void
    {
        if (!isset($data[self::KEY_WAS])) {
            return;
        }
        if (!is_array($data[self::KEY_WAS])) {
            return;
        }
        $model->setWas(self::toWasCondition($data[self::KEY_WAS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandDay(DateOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAY])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY])) {
            return;
        }
        $model->setDay($data[self::KEY_DAY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandDaysOfWeek(DateOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        if (!is_array($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        $model->setDaysOfWeek(array_values(array_filter($data[self::KEY_DAYS_OF_WEEK], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandMonth(DateOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_MONTH])) {
            return;
        }
        if (!is_int($data[self::KEY_MONTH])) {
            return;
        }
        $model->setMonth($data[self::KEY_MONTH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandReference(DateOperand $model, array $data): void
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return;
        }
        $model->setReference($data[self::KEY_REFERENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandTimeZoneId(DateOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateOperandYear(DateOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_YEAR])) {
            return;
        }
        if (!is_int($data[self::KEY_YEAR])) {
            return;
        }
        $model->setYear($data[self::KEY_YEAR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandDay(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAY])) {
            return;
        }
        if (!is_int($data[self::KEY_DAY])) {
            return;
        }
        $model->setDay($data[self::KEY_DAY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandDaysOfWeek(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        if (!is_array($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        $model->setDaysOfWeek(array_values(array_filter($data[self::KEY_DAYS_OF_WEEK], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandLocationId(DateTimeOperand $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandMonth(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_MONTH])) {
            return;
        }
        if (!is_int($data[self::KEY_MONTH])) {
            return;
        }
        $model->setMonth($data[self::KEY_MONTH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandOffset(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_array($data[self::KEY_OFFSET])) {
            return;
        }
        $model->setOffset(self::toInterval($data[self::KEY_OFFSET]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandTimeZoneId(DateTimeOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDateTimeOperandYear(DateTimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_YEAR])) {
            return;
        }
        if (!is_int($data[self::KEY_YEAR])) {
            return;
        }
        $model->setYear($data[self::KEY_YEAR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceOperandAggregation(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceOperandPath(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_PATH])) {
            return;
        }
        if (!is_string($data[self::KEY_PATH])) {
            return;
        }
        $model->setPath($data[self::KEY_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceOperandTrigger(DeviceOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TRIGGER])) {
            return;
        }
        if (!is_string($data[self::KEY_TRIGGER])) {
            return;
        }
        $model->setTrigger($data[self::KEY_TRIGGER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEqualsConditionAggregation(EqualsCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEqualsConditionChangesOnly(EqualsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEveryActionInterval(EveryAction $model, array $data): void
    {
        if (!isset($data[self::KEY_INTERVAL])) {
            return;
        }
        if (!is_array($data[self::KEY_INTERVAL])) {
            return;
        }
        $model->setInterval(self::toInterval($data[self::KEY_INTERVAL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEveryActionSequence(EveryAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence(self::toActionSequence($data[self::KEY_SEQUENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEveryActionSpecific(EveryAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SPECIFIC])) {
            return;
        }
        if (!is_array($data[self::KEY_SPECIFIC])) {
            return;
        }
        $model->setSpecific(self::toDateTimeOperand($data[self::KEY_SPECIFIC]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThanConditionAggregation(GreaterThanCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThanConditionChangesOnly(GreaterThanCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThanOrEqualsConditionAggregation(GreaterThanOrEqualsCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGreaterThanOrEqualsConditionChangesOnly(GreaterThanOrEqualsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionAnd(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionBetween(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween(self::toBetweenCondition($data[self::KEY_BETWEEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionChanges(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES])) {
            return;
        }
        if (!is_array($data[self::KEY_CHANGES])) {
            return;
        }
        $model->setChanges(self::toChangesCondition($data[self::KEY_CHANGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionElse(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_ELSE])) {
            return;
        }
        if (!is_array($data[self::KEY_ELSE])) {
            return;
        }
        $model->setElse(self::toActionList($data[self::KEY_ELSE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionEquals(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals(self::toEqualsCondition($data[self::KEY_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionGreaterThan(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan(self::toGreaterThanCondition($data[self::KEY_GREATER_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionGreaterThanOrEquals(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals(self::toGreaterThanOrEqualsCondition($data[self::KEY_GREATER_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionLessThan(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan(self::toLessThanCondition($data[self::KEY_LESS_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionLessThanOrEquals(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals(self::toLessThanOrEqualsCondition($data[self::KEY_LESS_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionNot(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot(self::toCondition($data[self::KEY_NOT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionOr(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionRemains(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_REMAINS])) {
            return;
        }
        if (!is_array($data[self::KEY_REMAINS])) {
            return;
        }
        $model->setRemains(self::toRemainsCondition($data[self::KEY_REMAINS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionSequence(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence(self::toIfActionSequence($data[self::KEY_SEQUENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionSequenceElse(IfActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_ELSE])) {
            return;
        }
        if (!is_string($data[self::KEY_ELSE])) {
            return;
        }
        $model->setElse($data[self::KEY_ELSE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionSequenceThen(IfActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_THEN])) {
            return;
        }
        if (!is_string($data[self::KEY_THEN])) {
            return;
        }
        $model->setThen($data[self::KEY_THEN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionThen(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_THEN])) {
            return;
        }
        if (!is_array($data[self::KEY_THEN])) {
            return;
        }
        $model->setThen(self::toActionList($data[self::KEY_THEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIfActionWas(IfAction $model, array $data): void
    {
        if (!isset($data[self::KEY_WAS])) {
            return;
        }
        if (!is_array($data[self::KEY_WAS])) {
            return;
        }
        $model->setWas(self::toWasCondition($data[self::KEY_WAS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThanConditionAggregation(LessThanCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThanConditionChangesOnly(LessThanCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThanOrEqualsConditionAggregation(LessThanOrEqualsCondition $model, array $data): void
    {
        if (empty($data[self::KEY_AGGREGATION])) {
            return;
        }
        if (!is_string($data[self::KEY_AGGREGATION])) {
            return;
        }
        $model->setAggregation($data[self::KEY_AGGREGATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLessThanOrEqualsConditionChangesOnly(LessThanOrEqualsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_CHANGES_ONLY])) {
            return;
        }
        $model->setChangesOnly($data[self::KEY_CHANGES_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLimitActionSequence(LimitAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SEQUENCE])) {
            return;
        }
        if (!is_array($data[self::KEY_SEQUENCE])) {
            return;
        }
        $model->setSequence(self::toActionSequence($data[self::KEY_SEQUENCE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationActionLocationId(LocationAction $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationActionMode(LocationAction $model, array $data): void
    {
        if (empty($data[self::KEY_MODE])) {
            return;
        }
        if (!is_string($data[self::KEY_MODE])) {
            return;
        }
        $model->setMode($data[self::KEY_MODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationOperandLocationId(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $model->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationOperandPostalCode(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $model->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationOperandTrigger(LocationOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TRIGGER])) {
            return;
        }
        if (!is_string($data[self::KEY_TRIGGER])) {
            return;
        }
        $model->setTrigger($data[self::KEY_TRIGGER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandArray(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_ARRAY])) {
            return;
        }
        if (!is_array($data[self::KEY_ARRAY])) {
            return;
        }
        $model->setArray(self::toArrayOperand($data[self::KEY_ARRAY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandBoolean(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_BOOLEAN])) {
            return;
        }
        if (!is_bool($data[self::KEY_BOOLEAN])) {
            return;
        }
        $model->setBoolean($data[self::KEY_BOOLEAN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandDate(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_DATE])) {
            return;
        }
        if (!is_array($data[self::KEY_DATE])) {
            return;
        }
        $model->setDate(self::toDateOperand($data[self::KEY_DATE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandDatetime(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_DATETIME])) {
            return;
        }
        if (!is_array($data[self::KEY_DATETIME])) {
            return;
        }
        $model->setDatetime(self::toDateTimeOperand($data[self::KEY_DATETIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandDecimal(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_DECIMAL])) {
            return;
        }
        if (!is_numeric($data[self::KEY_DECIMAL])) {
            return;
        }
        $model->setDecimal((float) $data[self::KEY_DECIMAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandDevice(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE])) {
            return;
        }
        $model->setDevice(self::toDeviceOperand($data[self::KEY_DEVICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandInteger(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_INTEGER])) {
            return;
        }
        if (!is_int($data[self::KEY_INTEGER])) {
            return;
        }
        $model->setInteger($data[self::KEY_INTEGER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandLocation(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $model->setLocation(self::toLocationOperand($data[self::KEY_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandMap(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_MAP])) {
            return;
        }
        if (!is_array($data[self::KEY_MAP])) {
            return;
        }
        $model->setMap(self::toOperandMap($data[self::KEY_MAP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandString(Operand $model, array $data): void
    {
        if (empty($data[self::KEY_STRING])) {
            return;
        }
        if (!is_string($data[self::KEY_STRING])) {
            return;
        }
        $model->setString($data[self::KEY_STRING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperandTime(Operand $model, array $data): void
    {
        if (!isset($data[self::KEY_TIME])) {
            return;
        }
        if (!is_array($data[self::KEY_TIME])) {
            return;
        }
        $model->setTime(self::toTimeOperand($data[self::KEY_TIME]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionAnd(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionBetween(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween(self::toBetweenCondition($data[self::KEY_BETWEEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionEquals(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals(self::toEqualsCondition($data[self::KEY_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionGreaterThan(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan(self::toGreaterThanCondition($data[self::KEY_GREATER_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionGreaterThanOrEquals(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals(self::toGreaterThanOrEqualsCondition($data[self::KEY_GREATER_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionLatching(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LATCHING])) {
            return;
        }
        if (!is_bool($data[self::KEY_LATCHING])) {
            return;
        }
        $model->setLatching($data[self::KEY_LATCHING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionLessThan(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan(self::toLessThanCondition($data[self::KEY_LESS_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionLessThanOrEquals(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals(self::toLessThanOrEqualsCondition($data[self::KEY_LESS_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionNot(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot(self::toCondition($data[self::KEY_NOT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionOperand(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OPERAND])) {
            return;
        }
        if (!is_array($data[self::KEY_OPERAND])) {
            return;
        }
        $model->setOperand(self::toOperand($data[self::KEY_OPERAND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRemainsConditionOr(RemainsCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRuleDeviceCommandArguments(RuleDeviceCommand $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments($data[self::KEY_ARGUMENTS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRuleDeviceCommandCommandId(RuleDeviceCommand $model, array $data): void
    {
        if (empty($data[self::KEY_COMMAND_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMAND_ID])) {
            return;
        }
        $model->setCommandId($data[self::KEY_COMMAND_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRuleDeviceCommandComponent(RuleDeviceCommand $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $model->setComponent($data[self::KEY_COMPONENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneActionDeviceGroupRequest(SceneAction $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_GROUP_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_GROUP_REQUEST])) {
            return;
        }
        $model->setDeviceGroupRequest(self::toSceneDeviceGroupRequest($data[self::KEY_DEVICE_GROUP_REQUEST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneActionDeviceRequest(SceneAction $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_REQUEST])) {
            return;
        }
        $model->setDeviceRequest(self::toSceneDeviceRequest($data[self::KEY_DEVICE_REQUEST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneActionModeRequest(SceneAction $model, array $data): void
    {
        if (!isset($data[self::KEY_MODE_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_MODE_REQUEST])) {
            return;
        }
        $model->setModeRequest(self::toSceneModeRequest($data[self::KEY_MODE_REQUEST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneActionSleepRequest(SceneAction $model, array $data): void
    {
        if (!isset($data[self::KEY_SLEEP_REQUEST])) {
            return;
        }
        if (!is_array($data[self::KEY_SLEEP_REQUEST])) {
            return;
        }
        $model->setSleepRequest(self::toSceneSleepRequest($data[self::KEY_SLEEP_REQUEST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneArgumentName(SceneArgument $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneArgumentSchema(SceneArgument $model, array $data): void
    {
        if (!isset($data[self::KEY_SCHEMA])) {
            return;
        }
        if (!is_array($data[self::KEY_SCHEMA])) {
            return;
        }
        $model->setSchema($data[self::KEY_SCHEMA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneArgumentValue(SceneArgument $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applySceneCapabilityCapabilityId(SceneCapability $model, array $data): void
    {
        if (empty($data[self::KEY_CAPABILITY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CAPABILITY_ID])) {
            return;
        }
        $model->setCapabilityId($data[self::KEY_CAPABILITY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneCapabilityCommands(SceneCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands(self::toSceneCommandMap($data[self::KEY_COMMANDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneCapabilityStatus(SceneCapability $model, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $model->setStatus($data[self::KEY_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneCommandArguments(SceneCommand $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments(self::toSceneArgumentList($data[self::KEY_ARGUMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneComponentCapabilities(SceneComponent $model, array $data): void
    {
        if (!isset($data[self::KEY_CAPABILITIES])) {
            return;
        }
        if (!is_array($data[self::KEY_CAPABILITIES])) {
            return;
        }
        $model->setCapabilities(self::toSceneCapabilityList($data[self::KEY_CAPABILITIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneComponentComponentId(SceneComponent $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT_ID])) {
            return;
        }
        $model->setComponentId($data[self::KEY_COMPONENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneDeviceGroupRequestActionId(SceneDeviceGroupRequest $model, array $data): void
    {
        if (empty($data[self::KEY_ACTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTION_ID])) {
            return;
        }
        $model->setActionId($data[self::KEY_ACTION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneDeviceGroupRequestCapability(SceneDeviceGroupRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_CAPABILITY])) {
            return;
        }
        if (!is_array($data[self::KEY_CAPABILITY])) {
            return;
        }
        $model->setCapability(self::toSceneCapability($data[self::KEY_CAPABILITY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneDeviceRequestActionId(SceneDeviceRequest $model, array $data): void
    {
        if (empty($data[self::KEY_ACTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTION_ID])) {
            return;
        }
        $model->setActionId($data[self::KEY_ACTION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneDeviceRequestComponents(SceneDeviceRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_COMPONENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            return;
        }
        $model->setComponents(self::toSceneComponentList($data[self::KEY_COMPONENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneDeviceRequestDeviceId(SceneDeviceRequest $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            return;
        }
        $model->setDeviceId($data[self::KEY_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneModeRequestActionId(SceneModeRequest $model, array $data): void
    {
        if (empty($data[self::KEY_ACTION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTION_ID])) {
            return;
        }
        $model->setActionId($data[self::KEY_ACTION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySceneModeRequestModeName(SceneModeRequest $model, array $data): void
    {
        if (empty($data[self::KEY_MODE_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MODE_NAME])) {
            return;
        }
        $model->setModeName($data[self::KEY_MODE_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeOperandDaysOfWeek(TimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        if (!is_array($data[self::KEY_DAYS_OF_WEEK])) {
            return;
        }
        $model->setDaysOfWeek(array_values(array_filter($data[self::KEY_DAYS_OF_WEEK], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeOperandOffset(TimeOperand $model, array $data): void
    {
        if (!isset($data[self::KEY_OFFSET])) {
            return;
        }
        if (!is_array($data[self::KEY_OFFSET])) {
            return;
        }
        $model->setOffset(self::toInterval($data[self::KEY_OFFSET]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTimeOperandTimeZoneId(TimeOperand $model, array $data): void
    {
        if (empty($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_TIME_ZONE_ID])) {
            return;
        }
        $model->setTimeZoneId($data[self::KEY_TIME_ZONE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionAnd(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_AND])) {
            return;
        }
        if (!is_array($data[self::KEY_AND])) {
            return;
        }
        $model->setAnd(self::toConditionList($data[self::KEY_AND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionBetween(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_BETWEEN])) {
            return;
        }
        if (!is_array($data[self::KEY_BETWEEN])) {
            return;
        }
        $model->setBetween(self::toBetweenCondition($data[self::KEY_BETWEEN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionEquals(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_EQUALS])) {
            return;
        }
        $model->setEquals(self::toEqualsCondition($data[self::KEY_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionGreaterThan(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN])) {
            return;
        }
        $model->setGreaterThan(self::toGreaterThanCondition($data[self::KEY_GREATER_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionGreaterThanOrEquals(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_GREATER_THAN_OR_EQUALS])) {
            return;
        }
        $model->setGreaterThanOrEquals(self::toGreaterThanOrEqualsCondition($data[self::KEY_GREATER_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionLessThan(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN])) {
            return;
        }
        $model->setLessThan(self::toLessThanCondition($data[self::KEY_LESS_THAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionLessThanOrEquals(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        if (!is_array($data[self::KEY_LESS_THAN_OR_EQUALS])) {
            return;
        }
        $model->setLessThanOrEquals(self::toLessThanOrEqualsCondition($data[self::KEY_LESS_THAN_OR_EQUALS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionNot(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_NOT])) {
            return;
        }
        if (!is_array($data[self::KEY_NOT])) {
            return;
        }
        $model->setNot(self::toCondition($data[self::KEY_NOT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionOperand(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OPERAND])) {
            return;
        }
        if (!is_array($data[self::KEY_OPERAND])) {
            return;
        }
        $model->setOperand(self::toOperand($data[self::KEY_OPERAND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWasConditionOr(WasCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_OR])) {
            return;
        }
        if (!is_array($data[self::KEY_OR])) {
            return;
        }
        $model->setOr(self::toConditionList($data[self::KEY_OR]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OperandInterface>
     */
    private static function requireArrayOperandOperands(array $data): array
    {
        if (!isset($data[self::KEY_OPERANDS])) {
            return [];
        }
        if (!is_array($data[self::KEY_OPERANDS])) {
            return [];
        }

        return self::toOperandList($data[self::KEY_OPERANDS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireBetweenConditionEnd(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_END])) {
            return null;
        }
        if (!is_array($data[self::KEY_END])) {
            return null;
        }

        return self::toOperand($data[self::KEY_END]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireBetweenConditionStart(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_START])) {
            return null;
        }
        if (!is_array($data[self::KEY_START])) {
            return null;
        }

        return self::toOperand($data[self::KEY_START]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireBetweenConditionValue(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return null;
        }

        return self::toOperand($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireChangesConditionId(array $data): ?string
    {
        if (empty($data[self::KEY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_ID])) {
            return null;
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleDeviceCommandInterface>
     */
    private static function requireCommandActionCommands(array $data): array
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return [];
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return [];
        }

        return self::toRuleDeviceCommandList($data[self::KEY_COMMANDS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    private static function requireCommandActionDevices(array $data): array
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return [];
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return [];
        }

        return array_values(array_filter($data[self::KEY_DEVICES], is_string(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDateTimeOperandReference(array $data): ?string
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return null;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return null;
        }

        return $data[self::KEY_REFERENCE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceOperandAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceOperandCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDeviceOperandComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    private static function requireDeviceOperandDevices(array $data): array
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return [];
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return [];
        }

        return array_values(array_filter($data[self::KEY_DEVICES], is_string(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireEqualsConditionLeft(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_LEFT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireEqualsConditionRight(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_RIGHT]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    private static function requireEveryActionActions(array $data): array
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return [];
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return [];
        }

        return self::toActionList($data[self::KEY_ACTIONS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireGreaterThanConditionLeft(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_LEFT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireGreaterThanConditionRight(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_RIGHT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireGreaterThanOrEqualsConditionLeft(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_LEFT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireGreaterThanOrEqualsConditionRight(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_RIGHT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireIntervalUnit(array $data): ?string
    {
        if (empty($data[self::KEY_UNIT])) {
            return null;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return null;
        }

        return $data[self::KEY_UNIT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireIntervalValue(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return null;
        }

        return self::toOperand($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLessThanConditionLeft(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_LEFT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLessThanConditionRight(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_RIGHT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLessThanOrEqualsConditionLeft(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_LEFT])) {
            return null;
        }
        if (!is_array($data[self::KEY_LEFT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_LEFT]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLessThanOrEqualsConditionRight(array $data): ?OperandInterface
    {
        if (!isset($data[self::KEY_RIGHT])) {
            return null;
        }
        if (!is_array($data[self::KEY_RIGHT])) {
            return null;
        }

        return self::toOperand($data[self::KEY_RIGHT]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    private static function requireLimitActionActions(array $data): array
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return [];
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return [];
        }

        return self::toActionList($data[self::KEY_ACTIONS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLimitActionCount(array $data): ?int
    {
        if (!isset($data[self::KEY_COUNT])) {
            return null;
        }
        if (!is_int($data[self::KEY_COUNT])) {
            return null;
        }

        return $data[self::KEY_COUNT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLimitActionPeriod(array $data): ?string
    {
        if (empty($data[self::KEY_PERIOD])) {
            return null;
        }
        if (!is_string($data[self::KEY_PERIOD])) {
            return null;
        }

        return $data[self::KEY_PERIOD];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLocationOperandAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRemainsConditionDuration(array $data): ?IntervalInterface
    {
        if (!isset($data[self::KEY_DURATION])) {
            return null;
        }
        if (!is_array($data[self::KEY_DURATION])) {
            return null;
        }

        return self::toInterval($data[self::KEY_DURATION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRemainsConditionId(array $data): ?string
    {
        if (empty($data[self::KEY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_ID])) {
            return null;
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRuleDeviceCommandCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRuleDeviceCommandCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSceneDeviceGroupRequestDeviceGroupId(array $data): ?string
    {
        if (empty($data[self::KEY_DEVICE_GROUP_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_DEVICE_GROUP_ID])) {
            return null;
        }

        return $data[self::KEY_DEVICE_GROUP_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSceneModeRequestModeId(array $data): ?string
    {
        if (empty($data[self::KEY_MODE_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_MODE_ID])) {
            return null;
        }

        return $data[self::KEY_MODE_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSceneSleepRequestSeconds(array $data): ?int
    {
        if (!isset($data[self::KEY_SECONDS])) {
            return null;
        }
        if (!is_int($data[self::KEY_SECONDS])) {
            return null;
        }

        return $data[self::KEY_SECONDS];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSleepActionDuration(array $data): ?IntervalInterface
    {
        if (!isset($data[self::KEY_DURATION])) {
            return null;
        }
        if (!is_array($data[self::KEY_DURATION])) {
            return null;
        }

        return self::toInterval($data[self::KEY_DURATION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTimeOperandReference(array $data): ?string
    {
        if (empty($data[self::KEY_REFERENCE])) {
            return null;
        }
        if (!is_string($data[self::KEY_REFERENCE])) {
            return null;
        }

        return $data[self::KEY_REFERENCE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireToggleActionAttribute(array $data): ?string
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return null;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return null;
        }

        return $data[self::KEY_ATTRIBUTE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireToggleActionCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireToggleActionComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    private static function requireToggleActionDevices(array $data): array
    {
        if (!isset($data[self::KEY_DEVICES])) {
            return [];
        }
        if (!is_array($data[self::KEY_DEVICES])) {
            return [];
        }

        return array_values(array_filter($data[self::KEY_DEVICES], is_string(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireWasConditionDuration(array $data): ?IntervalInterface
    {
        if (!isset($data[self::KEY_DURATION])) {
            return null;
        }
        if (!is_array($data[self::KEY_DURATION])) {
            return null;
        }

        return self::toInterval($data[self::KEY_DURATION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireWasConditionId(array $data): ?string
    {
        if (empty($data[self::KEY_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_ID])) {
            return null;
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function toAction(array $data): ActionInterface
    {
        $model = new Action();

        self::applyActionIf($model, $data);
        self::applyActionSleep($model, $data);
        self::applyActionCommand($model, $data);
        self::applyActionScene($model, $data);
        self::applyActionEvery($model, $data);
        self::applyActionLocation($model, $data);
        self::applyActionLimit($model, $data);
        self::applyActionToggle($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    private static function toActionList(array $data): array
    {
        return array_values(array_map(static fn (array $item): ActionInterface => self::toAction($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionInterface>
     */
    private static function toActionMap(array $data): array
    {
        return array_map(static fn (array $item): ActionInterface => self::toAction($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function toActionSequence(array $data): ActionSequenceInterface
    {
        $model = new ActionSequence();

        self::applyActionSequenceActions($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionSequenceInterface>
     */
    private static function toActionSequenceList(array $data): array
    {
        return array_values(array_map(static fn (array $item): ActionSequenceInterface => self::toActionSequence($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionSequenceInterface>
     */
    private static function toActionSequenceMap(array $data): array
    {
        return array_map(static fn (array $item): ActionSequenceInterface => self::toActionSequence($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function toArrayOperand(array $data): ArrayOperandInterface
    {
        $model = new ArrayOperand(self::requireArrayOperandOperands($data));

        self::applyArrayOperandAggregation($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toBetweenCondition(array $data): BetweenConditionInterface
    {
        $model = new BetweenCondition(self::requireBetweenConditionValue($data), self::requireBetweenConditionStart($data), self::requireBetweenConditionEnd($data));

        self::applyBetweenConditionAggregation($model, $data);
        self::applyBetweenConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toChangesCondition(array $data): ChangesConditionInterface
    {
        $model = new ChangesCondition(self::requireChangesConditionId($data));

        self::applyChangesConditionAnd($model, $data);
        self::applyChangesConditionOr($model, $data);
        self::applyChangesConditionNot($model, $data);
        self::applyChangesConditionEquals($model, $data);
        self::applyChangesConditionGreaterThan($model, $data);
        self::applyChangesConditionGreaterThanOrEquals($model, $data);
        self::applyChangesConditionLessThan($model, $data);
        self::applyChangesConditionLessThanOrEquals($model, $data);
        self::applyChangesConditionBetween($model, $data);
        self::applyChangesConditionOperand($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toCommandAction(array $data): CommandActionInterface
    {
        $model = new CommandAction(self::requireCommandActionDevices($data), self::requireCommandActionCommands($data));

        self::applyCommandActionSequence($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toCommandSequence(array $data): CommandSequenceInterface
    {
        $model = new CommandSequence();

        self::applyCommandSequenceCommands($model, $data);
        self::applyCommandSequenceDevices($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toCondition(array $data): ConditionInterface
    {
        $model = new Condition();

        self::applyConditionAnd($model, $data);
        self::applyConditionOr($model, $data);
        self::applyConditionNot($model, $data);
        self::applyConditionEquals($model, $data);
        self::applyConditionGreaterThan($model, $data);
        self::applyConditionGreaterThanOrEquals($model, $data);
        self::applyConditionLessThan($model, $data);
        self::applyConditionLessThanOrEquals($model, $data);
        self::applyConditionBetween($model, $data);
        self::applyConditionChanges($model, $data);
        self::applyConditionRemains($model, $data);
        self::applyConditionWas($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ConditionInterface>
     */
    private static function toConditionList(array $data): array
    {
        return array_values(array_map(static fn (array $item): ConditionInterface => self::toCondition($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function toDateOperand(array $data): DateOperandInterface
    {
        $model = new DateOperand();

        self::applyDateOperandTimeZoneId($model, $data);
        self::applyDateOperandDaysOfWeek($model, $data);
        self::applyDateOperandYear($model, $data);
        self::applyDateOperandMonth($model, $data);
        self::applyDateOperandDay($model, $data);
        self::applyDateOperandReference($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toDateTimeOperand(array $data): DateTimeOperandInterface
    {
        $model = new DateTimeOperand(self::requireDateTimeOperandReference($data));

        self::applyDateTimeOperandTimeZoneId($model, $data);
        self::applyDateTimeOperandLocationId($model, $data);
        self::applyDateTimeOperandDaysOfWeek($model, $data);
        self::applyDateTimeOperandYear($model, $data);
        self::applyDateTimeOperandMonth($model, $data);
        self::applyDateTimeOperandDay($model, $data);
        self::applyDateTimeOperandOffset($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toDeviceOperand(array $data): DeviceOperandInterface
    {
        $model = new DeviceOperand(self::requireDeviceOperandDevices($data), self::requireDeviceOperandComponent($data), self::requireDeviceOperandCapability($data), self::requireDeviceOperandAttribute($data));

        self::applyDeviceOperandPath($model, $data);
        self::applyDeviceOperandAggregation($model, $data);
        self::applyDeviceOperandTrigger($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toEqualsCondition(array $data): EqualsConditionInterface
    {
        $model = new EqualsCondition(self::requireEqualsConditionLeft($data), self::requireEqualsConditionRight($data));

        self::applyEqualsConditionAggregation($model, $data);
        self::applyEqualsConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toEveryAction(array $data): EveryActionInterface
    {
        $model = new EveryAction(self::requireEveryActionActions($data));

        self::applyEveryActionInterval($model, $data);
        self::applyEveryActionSpecific($model, $data);
        self::applyEveryActionSequence($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toGreaterThanCondition(array $data): GreaterThanConditionInterface
    {
        $model = new GreaterThanCondition(self::requireGreaterThanConditionLeft($data), self::requireGreaterThanConditionRight($data));

        self::applyGreaterThanConditionAggregation($model, $data);
        self::applyGreaterThanConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toGreaterThanOrEqualsCondition(array $data): GreaterThanOrEqualsConditionInterface
    {
        $model = new GreaterThanOrEqualsCondition(self::requireGreaterThanOrEqualsConditionLeft($data), self::requireGreaterThanOrEqualsConditionRight($data));

        self::applyGreaterThanOrEqualsConditionAggregation($model, $data);
        self::applyGreaterThanOrEqualsConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toIfAction(array $data): IfActionInterface
    {
        $model = new IfAction();

        self::applyIfActionAnd($model, $data);
        self::applyIfActionOr($model, $data);
        self::applyIfActionNot($model, $data);
        self::applyIfActionEquals($model, $data);
        self::applyIfActionGreaterThan($model, $data);
        self::applyIfActionGreaterThanOrEquals($model, $data);
        self::applyIfActionLessThan($model, $data);
        self::applyIfActionLessThanOrEquals($model, $data);
        self::applyIfActionBetween($model, $data);
        self::applyIfActionChanges($model, $data);
        self::applyIfActionRemains($model, $data);
        self::applyIfActionWas($model, $data);
        self::applyIfActionThen($model, $data);
        self::applyIfActionElse($model, $data);
        self::applyIfActionSequence($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toIfActionSequence(array $data): IfActionSequenceInterface
    {
        $model = new IfActionSequence();

        self::applyIfActionSequenceThen($model, $data);
        self::applyIfActionSequenceElse($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toInterval(array $data): IntervalInterface
    {
        $model = new Interval(self::requireIntervalValue($data), self::requireIntervalUnit($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toLessThanCondition(array $data): LessThanConditionInterface
    {
        $model = new LessThanCondition(self::requireLessThanConditionLeft($data), self::requireLessThanConditionRight($data));

        self::applyLessThanConditionAggregation($model, $data);
        self::applyLessThanConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toLessThanOrEqualsCondition(array $data): LessThanOrEqualsConditionInterface
    {
        $model = new LessThanOrEqualsCondition(self::requireLessThanOrEqualsConditionLeft($data), self::requireLessThanOrEqualsConditionRight($data));

        self::applyLessThanOrEqualsConditionAggregation($model, $data);
        self::applyLessThanOrEqualsConditionChangesOnly($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toLimitAction(array $data): LimitActionInterface
    {
        $model = new LimitAction(self::requireLimitActionCount($data), self::requireLimitActionPeriod($data), self::requireLimitActionActions($data));

        self::applyLimitActionSequence($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toLocationAction(array $data): LocationActionInterface
    {
        $model = new LocationAction();

        self::applyLocationActionLocationId($model, $data);
        self::applyLocationActionMode($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toLocationOperand(array $data): LocationOperandInterface
    {
        $model = new LocationOperand(self::requireLocationOperandAttribute($data));

        self::applyLocationOperandLocationId($model, $data);
        self::applyLocationOperandPostalCode($model, $data);
        self::applyLocationOperandTrigger($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toOperand(array $data): OperandInterface
    {
        $model = new Operand();

        self::applyOperandBoolean($model, $data);
        self::applyOperandDecimal($model, $data);
        self::applyOperandInteger($model, $data);
        self::applyOperandString($model, $data);
        self::applyOperandArray($model, $data);
        self::applyOperandMap($model, $data);
        self::applyOperandDevice($model, $data);
        self::applyOperandLocation($model, $data);
        self::applyOperandDate($model, $data);
        self::applyOperandTime($model, $data);
        self::applyOperandDatetime($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, OperandInterface>
     */
    private static function toOperandList(array $data): array
    {
        return array_values(array_map(static fn (array $item): OperandInterface => self::toOperand($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, OperandInterface>
     */
    private static function toOperandMap(array $data): array
    {
        return array_map(static fn (array $item): OperandInterface => self::toOperand($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function toRemainsCondition(array $data): RemainsConditionInterface
    {
        $model = new RemainsCondition(self::requireRemainsConditionId($data), self::requireRemainsConditionDuration($data));

        self::applyRemainsConditionAnd($model, $data);
        self::applyRemainsConditionOr($model, $data);
        self::applyRemainsConditionNot($model, $data);
        self::applyRemainsConditionEquals($model, $data);
        self::applyRemainsConditionGreaterThan($model, $data);
        self::applyRemainsConditionGreaterThanOrEquals($model, $data);
        self::applyRemainsConditionLessThan($model, $data);
        self::applyRemainsConditionLessThanOrEquals($model, $data);
        self::applyRemainsConditionBetween($model, $data);
        self::applyRemainsConditionOperand($model, $data);
        self::applyRemainsConditionLatching($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toRuleDeviceCommand(array $data): RuleDeviceCommandInterface
    {
        $model = new RuleDeviceCommand(self::requireRuleDeviceCommandCapability($data), self::requireRuleDeviceCommandCommand($data));

        self::applyRuleDeviceCommandComponent($model, $data);
        self::applyRuleDeviceCommandArguments($model, $data);
        self::applyRuleDeviceCommandCommandId($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleDeviceCommandInterface>
     */
    private static function toRuleDeviceCommandList(array $data): array
    {
        return array_values(array_map(static fn (array $item): RuleDeviceCommandInterface => self::toRuleDeviceCommand($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneAction(array $data): SceneActionInterface
    {
        $model = new SceneAction();

        self::applySceneActionDeviceRequest($model, $data);
        self::applySceneActionModeRequest($model, $data);
        self::applySceneActionSleepRequest($model, $data);
        self::applySceneActionDeviceGroupRequest($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneArgument(array $data): SceneArgumentInterface
    {
        $model = new SceneArgument();

        self::applySceneArgumentName($model, $data);
        self::applySceneArgumentSchema($model, $data);
        self::applySceneArgumentValue($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneArgumentInterface>
     */
    private static function toSceneArgumentList(array $data): array
    {
        return array_values(array_map(static fn (array $item): SceneArgumentInterface => self::toSceneArgument($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneCapability(array $data): SceneCapabilityInterface
    {
        $model = new SceneCapability();

        self::applySceneCapabilityCapabilityId($model, $data);
        self::applySceneCapabilityStatus($model, $data);
        self::applySceneCapabilityCommands($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneCapabilityInterface>
     */
    private static function toSceneCapabilityList(array $data): array
    {
        return array_values(array_map(static fn (array $item): SceneCapabilityInterface => self::toSceneCapability($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneCommand(array $data): SceneCommandInterface
    {
        $model = new SceneCommand();

        self::applySceneCommandArguments($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, SceneCommandInterface>
     */
    private static function toSceneCommandMap(array $data): array
    {
        return array_map(static fn (array $item): SceneCommandInterface => self::toSceneCommand($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneComponent(array $data): SceneComponentInterface
    {
        $model = new SceneComponent();

        self::applySceneComponentComponentId($model, $data);
        self::applySceneComponentCapabilities($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, SceneComponentInterface>
     */
    private static function toSceneComponentList(array $data): array
    {
        return array_values(array_map(static fn (array $item): SceneComponentInterface => self::toSceneComponent($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneDeviceGroupRequest(array $data): SceneDeviceGroupRequestInterface
    {
        $model = new SceneDeviceGroupRequest(self::requireSceneDeviceGroupRequestDeviceGroupId($data));

        self::applySceneDeviceGroupRequestActionId($model, $data);
        self::applySceneDeviceGroupRequestCapability($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneDeviceRequest(array $data): SceneDeviceRequestInterface
    {
        $model = new SceneDeviceRequest();

        self::applySceneDeviceRequestDeviceId($model, $data);
        self::applySceneDeviceRequestActionId($model, $data);
        self::applySceneDeviceRequestComponents($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneModeRequest(array $data): SceneModeRequestInterface
    {
        $model = new SceneModeRequest(self::requireSceneModeRequestModeId($data));

        self::applySceneModeRequestActionId($model, $data);
        self::applySceneModeRequestModeName($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toSceneSleepRequest(array $data): SceneSleepRequestInterface
    {
        $model = new SceneSleepRequest(self::requireSceneSleepRequestSeconds($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toSleepAction(array $data): SleepActionInterface
    {
        $model = new SleepAction(self::requireSleepActionDuration($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toTimeOperand(array $data): TimeOperandInterface
    {
        $model = new TimeOperand(self::requireTimeOperandReference($data));

        self::applyTimeOperandTimeZoneId($model, $data);
        self::applyTimeOperandDaysOfWeek($model, $data);
        self::applyTimeOperandOffset($model, $data);

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toToggleAction(array $data): ToggleActionInterface
    {
        $model = new ToggleAction(self::requireToggleActionDevices($data), self::requireToggleActionComponent($data), self::requireToggleActionCapability($data), self::requireToggleActionAttribute($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function toWasCondition(array $data): WasConditionInterface
    {
        $model = new WasCondition(self::requireWasConditionId($data), self::requireWasConditionDuration($data));

        self::applyWasConditionAnd($model, $data);
        self::applyWasConditionOr($model, $data);
        self::applyWasConditionNot($model, $data);
        self::applyWasConditionEquals($model, $data);
        self::applyWasConditionGreaterThan($model, $data);
        self::applyWasConditionGreaterThanOrEquals($model, $data);
        self::applyWasConditionLessThan($model, $data);
        self::applyWasConditionLessThanOrEquals($model, $data);
        self::applyWasConditionBetween($model, $data);
        self::applyWasConditionOperand($model, $data);

        return $model;
    }
}
