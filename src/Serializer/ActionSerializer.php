<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\ArrayOperandInterface;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;
use ChristianBrown\SmartThings\Model\ChangesConditionInterface;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;
use ChristianBrown\SmartThings\Model\ConditionInterface;
use ChristianBrown\SmartThings\Model\DateOperandInterface;
use ChristianBrown\SmartThings\Model\DateTimeOperandInterface;
use ChristianBrown\SmartThings\Model\DeviceOperandInterface;
use ChristianBrown\SmartThings\Model\EqualsConditionInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;
use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\LessThanConditionInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;
use ChristianBrown\SmartThings\Model\LocationActionInterface;
use ChristianBrown\SmartThings\Model\LocationOperandInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Model\RemainsConditionInterface;
use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SceneArgumentInterface;
use ChristianBrown\SmartThings\Model\SceneCapabilityInterface;
use ChristianBrown\SmartThings\Model\SceneCommandInterface;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceRequestInterface;
use ChristianBrown\SmartThings\Model\SceneModeRequestInterface;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;
use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;
use ChristianBrown\SmartThings\Model\WasConditionInterface;

use function array_filter;
use function array_map;

final class ActionSerializer implements ActionSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ActionInterface $request): array
    {
        return self::filter([
            self::KEY_IF => self::serializeOptionalIfAction($request->getIf()),
            self::KEY_SLEEP => self::serializeOptionalSleepAction($request->getSleep()),
            self::KEY_COMMAND => self::serializeOptionalCommandAction($request->getCommand()),
            self::KEY_SCENE => self::serializeOptionalSceneAction($request->getScene()),
            self::KEY_EVERY => self::serializeOptionalEveryAction($request->getEvery()),
            self::KEY_LOCATION => self::serializeOptionalLocationAction($request->getLocation()),
            self::KEY_LIMIT => self::serializeOptionalLimitAction($request->getLimit()),
            self::KEY_TOGGLE => self::serializeOptionalToggleAction($request->getToggle()),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAction(ActionInterface $value): array
    {
        return self::filter([
            self::KEY_IF => self::serializeOptionalIfAction($value->getIf()),
            self::KEY_SLEEP => self::serializeOptionalSleepAction($value->getSleep()),
            self::KEY_COMMAND => self::serializeOptionalCommandAction($value->getCommand()),
            self::KEY_SCENE => self::serializeOptionalSceneAction($value->getScene()),
            self::KEY_EVERY => self::serializeOptionalEveryAction($value->getEvery()),
            self::KEY_LOCATION => self::serializeOptionalLocationAction($value->getLocation()),
            self::KEY_LIMIT => self::serializeOptionalLimitAction($value->getLimit()),
            self::KEY_TOGGLE => self::serializeOptionalToggleAction($value->getToggle()),
        ]);
    }

    /**
     * @param null|array<int, ActionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeActionList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (ActionInterface $item): array => self::serializeAction($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeActionSequence(ActionSequenceInterface $value): array
    {
        return self::filter([
            self::KEY_ACTIONS => $value->getActions(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeArrayOperand(ArrayOperandInterface $value): array
    {
        return self::filter([
            self::KEY_OPERANDS => self::serializeRequiredOperandList($value->getOperands()),
            self::KEY_AGGREGATION => $value->getAggregation(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeBetweenCondition(BetweenConditionInterface $value): array
    {
        return self::filter([
            self::KEY_VALUE => self::serializeOperand($value->getValue()),
            self::KEY_START => self::serializeOperand($value->getStart()),
            self::KEY_END => self::serializeOperand($value->getEnd()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeChangesCondition(ChangesConditionInterface $value): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd()),
            self::KEY_OR => self::serializeConditionList($value->getOr()),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot()),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals()),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan()),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals()),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan()),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals()),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween()),
            self::KEY_ID => $value->getId(),
            self::KEY_OPERAND => self::serializeOptionalOperand($value->getOperand()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCommandAction(CommandActionInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICES => $value->getDevices(),
            self::KEY_COMMANDS => self::serializeRequiredRuleDeviceCommandList($value->getCommands()),
            self::KEY_SEQUENCE => self::serializeOptionalCommandSequence($value->getSequence()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCommandSequence(CommandSequenceInterface $value): array
    {
        return self::filter([
            self::KEY_COMMANDS => $value->getCommands(),
            self::KEY_DEVICES => $value->getDevices(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCondition(ConditionInterface $value): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd()),
            self::KEY_OR => self::serializeConditionList($value->getOr()),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot()),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals()),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan()),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals()),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan()),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals()),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween()),
            self::KEY_CHANGES => self::serializeOptionalChangesCondition($value->getChanges()),
            self::KEY_REMAINS => self::serializeOptionalRemainsCondition($value->getRemains()),
            self::KEY_WAS => self::serializeOptionalWasCondition($value->getWas()),
        ]);
    }

    /**
     * @param null|array<int, ConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeConditionList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (ConditionInterface $item): array => self::serializeCondition($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDateOperand(DateOperandInterface $value): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_YEAR => $value->getYear(),
            self::KEY_MONTH => $value->getMonth(),
            self::KEY_DAY => $value->getDay(),
            self::KEY_REFERENCE => $value->getReference(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDateTimeOperand(DateTimeOperandInterface $value): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_YEAR => $value->getYear(),
            self::KEY_MONTH => $value->getMonth(),
            self::KEY_DAY => $value->getDay(),
            self::KEY_REFERENCE => $value->getReference(),
            self::KEY_OFFSET => self::serializeOptionalInterval($value->getOffset()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeDeviceOperand(DeviceOperandInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICES => $value->getDevices(),
            self::KEY_COMPONENT => $value->getComponent(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_PATH => $value->getPath(),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_TRIGGER => $value->getTrigger(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeEqualsCondition(EqualsConditionInterface $value): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOperand($value->getLeft()),
            self::KEY_RIGHT => self::serializeOperand($value->getRight()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeEveryAction(EveryActionInterface $value): array
    {
        return self::filter([
            self::KEY_INTERVAL => self::serializeOptionalInterval($value->getInterval()),
            self::KEY_SPECIFIC => self::serializeOptionalDateTimeOperand($value->getSpecific()),
            self::KEY_ACTIONS => self::serializeRequiredActionList($value->getActions()),
            self::KEY_SEQUENCE => self::serializeOptionalActionSequence($value->getSequence()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeGreaterThanCondition(GreaterThanConditionInterface $value): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOperand($value->getLeft()),
            self::KEY_RIGHT => self::serializeOperand($value->getRight()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeGreaterThanOrEqualsCondition(GreaterThanOrEqualsConditionInterface $value): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOperand($value->getLeft()),
            self::KEY_RIGHT => self::serializeOperand($value->getRight()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeIfAction(IfActionInterface $value): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd()),
            self::KEY_OR => self::serializeConditionList($value->getOr()),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot()),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals()),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan()),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals()),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan()),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals()),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween()),
            self::KEY_CHANGES => self::serializeOptionalChangesCondition($value->getChanges()),
            self::KEY_REMAINS => self::serializeOptionalRemainsCondition($value->getRemains()),
            self::KEY_WAS => self::serializeOptionalWasCondition($value->getWas()),
            self::KEY_THEN => self::serializeActionList($value->getThen()),
            self::KEY_ELSE => self::serializeActionList($value->getElse()),
            self::KEY_SEQUENCE => self::serializeOptionalIfActionSequence($value->getSequence()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeIfActionSequence(IfActionSequenceInterface $value): array
    {
        return self::filter([
            self::KEY_THEN => $value->getThen(),
            self::KEY_ELSE => $value->getElse(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeInterval(IntervalInterface $value): array
    {
        return self::filter([
            self::KEY_VALUE => self::serializeOperand($value->getValue()),
            self::KEY_UNIT => $value->getUnit(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeLessThanCondition(LessThanConditionInterface $value): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOperand($value->getLeft()),
            self::KEY_RIGHT => self::serializeOperand($value->getRight()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeLessThanOrEqualsCondition(LessThanOrEqualsConditionInterface $value): array
    {
        return self::filter([
            self::KEY_LEFT => self::serializeOperand($value->getLeft()),
            self::KEY_RIGHT => self::serializeOperand($value->getRight()),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_CHANGES_ONLY => $value->getChangesOnly(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeLimitAction(LimitActionInterface $value): array
    {
        return self::filter([
            self::KEY_COUNT => $value->getCount(),
            self::KEY_PERIOD => $value->getPeriod(),
            self::KEY_ACTIONS => self::serializeRequiredActionList($value->getActions()),
            self::KEY_SEQUENCE => self::serializeOptionalActionSequence($value->getSequence()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeLocationAction(LocationActionInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_MODE => $value->getMode(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeLocationOperand(LocationOperandInterface $value): array
    {
        return self::filter([
            self::KEY_LOCATION_ID => $value->getLocationId(),
            self::KEY_POSTAL_CODE => $value->getPostalCode(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_TRIGGER => $value->getTrigger(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeOperand(OperandInterface $value): array
    {
        return self::filter([
            self::KEY_BOOLEAN => $value->getBoolean(),
            self::KEY_DECIMAL => $value->getDecimal(),
            self::KEY_INTEGER => $value->getInteger(),
            self::KEY_STRING => $value->getString(),
            self::KEY_ARRAY => self::serializeOptionalArrayOperand($value->getArray()),
            self::KEY_MAP => self::serializeOperandMap($value->getMap()),
            self::KEY_DEVICE => self::serializeOptionalDeviceOperand($value->getDevice()),
            self::KEY_LOCATION => self::serializeOptionalLocationOperand($value->getLocation()),
            self::KEY_DATE => self::serializeOptionalDateOperand($value->getDate()),
            self::KEY_TIME => self::serializeOptionalTimeOperand($value->getTime()),
            self::KEY_DATETIME => self::serializeOptionalDateTimeOperand($value->getDatetime()),
        ]);
    }

    /**
     * @param null|array<array-key, OperandInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeOperandMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (OperandInterface $item): array => self::serializeOperand($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalActionSequence(?ActionSequenceInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeActionSequence($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalArrayOperand(?ArrayOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeArrayOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalBetweenCondition(?BetweenConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeBetweenCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalChangesCondition(?ChangesConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeChangesCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCommandAction(?CommandActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCommandAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCommandSequence(?CommandSequenceInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCommandSequence($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCondition(?ConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDateOperand(?DateOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDateOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDateTimeOperand(?DateTimeOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDateTimeOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalDeviceOperand(?DeviceOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeDeviceOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalEqualsCondition(?EqualsConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeEqualsCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalEveryAction(?EveryActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeEveryAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalGreaterThanCondition(?GreaterThanConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeGreaterThanCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalGreaterThanOrEqualsCondition(?GreaterThanOrEqualsConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeGreaterThanOrEqualsCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalIfAction(?IfActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeIfAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalIfActionSequence(?IfActionSequenceInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeIfActionSequence($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalInterval(?IntervalInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeInterval($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLessThanCondition(?LessThanConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeLessThanCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLessThanOrEqualsCondition(?LessThanOrEqualsConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeLessThanOrEqualsCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLimitAction(?LimitActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeLimitAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLocationAction(?LocationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeLocationAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalLocationOperand(?LocationOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeLocationOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalOperand(?OperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalRemainsCondition(?RemainsConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeRemainsCondition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneAction(?SceneActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneCapability(?SceneCapabilityInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneCapability($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneDeviceGroupRequest(?SceneDeviceGroupRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneDeviceGroupRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneDeviceRequest(?SceneDeviceRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneDeviceRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneModeRequest(?SceneModeRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneModeRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSceneSleepRequest(?SceneSleepRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSceneSleepRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalSleepAction(?SleepActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeSleepAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalTimeOperand(?TimeOperandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeTimeOperand($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalToggleAction(?ToggleActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeToggleAction($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalWasCondition(?WasConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeWasCondition($value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeRemainsCondition(RemainsConditionInterface $value): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd()),
            self::KEY_OR => self::serializeConditionList($value->getOr()),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot()),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals()),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan()),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals()),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan()),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals()),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween()),
            self::KEY_ID => $value->getId(),
            self::KEY_OPERAND => self::serializeOptionalOperand($value->getOperand()),
            self::KEY_DURATION => self::serializeInterval($value->getDuration()),
            self::KEY_LATCHING => $value->getLatching(),
        ]);
    }

    /**
     * @param array<int, ActionInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredActionList(array $values): array
    {
        return array_map(static fn (ActionInterface $item): array => self::serializeAction($item), $values);
    }

    /**
     * @param array<int, OperandInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredOperandList(array $values): array
    {
        return array_map(static fn (OperandInterface $item): array => self::serializeOperand($item), $values);
    }

    /**
     * @param array<int, RuleDeviceCommandInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private static function serializeRequiredRuleDeviceCommandList(array $values): array
    {
        return array_map(static fn (RuleDeviceCommandInterface $item): array => self::serializeRuleDeviceCommand($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeRuleDeviceCommand(RuleDeviceCommandInterface $value): array
    {
        return self::filter([
            self::KEY_COMPONENT => $value->getComponent(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_COMMAND => $value->getCommand(),
            self::KEY_ARGUMENTS => $value->getArguments(),
            self::KEY_COMMAND_ID => $value->getCommandId(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneAction(SceneActionInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_REQUEST => self::serializeOptionalSceneDeviceRequest($value->getDeviceRequest()),
            self::KEY_MODE_REQUEST => self::serializeOptionalSceneModeRequest($value->getModeRequest()),
            self::KEY_SLEEP_REQUEST => self::serializeOptionalSceneSleepRequest($value->getSleepRequest()),
            self::KEY_DEVICE_GROUP_REQUEST => self::serializeOptionalSceneDeviceGroupRequest($value->getDeviceGroupRequest()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneArgument(SceneArgumentInterface $value): array
    {
        return self::filter([
            self::KEY_NAME => $value->getName(),
            self::KEY_SCHEMA => $value->getSchema(),
            self::KEY_VALUE => $value->getValue(),
        ]);
    }

    /**
     * @param null|array<int, SceneArgumentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneArgumentList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneArgumentInterface $item): array => self::serializeSceneArgument($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneCapability(SceneCapabilityInterface $value): array
    {
        return self::filter([
            self::KEY_CAPABILITY_ID => $value->getCapabilityId(),
            self::KEY_STATUS => $value->getStatus(),
            self::KEY_COMMANDS => self::serializeSceneCommandMap($value->getCommands()),
        ]);
    }

    /**
     * @param null|array<int, SceneCapabilityInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneCapabilityList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneCapabilityInterface $item): array => self::serializeSceneCapability($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneCommand(SceneCommandInterface $value): array
    {
        return self::filter([
            self::KEY_ARGUMENTS => self::serializeSceneArgumentList($value->getArguments()),
        ]);
    }

    /**
     * @param null|array<array-key, SceneCommandInterface> $values
     *
     * @return null|array<array-key, mixed[]>
     */
    private static function serializeSceneCommandMap(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneCommandInterface $item): array => self::serializeSceneCommand($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneComponent(SceneComponentInterface $value): array
    {
        return self::filter([
            self::KEY_COMPONENT_ID => $value->getComponentId(),
            self::KEY_CAPABILITIES => self::serializeSceneCapabilityList($value->getCapabilities()),
        ]);
    }

    /**
     * @param null|array<int, SceneComponentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSceneComponentList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SceneComponentInterface $item): array => self::serializeSceneComponent($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneDeviceGroupRequest(SceneDeviceGroupRequestInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_GROUP_ID => $value->getDeviceGroupId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_CAPABILITY => self::serializeOptionalSceneCapability($value->getCapability()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneDeviceRequest(SceneDeviceRequestInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICE_ID => $value->getDeviceId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_COMPONENTS => self::serializeSceneComponentList($value->getComponents()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneModeRequest(SceneModeRequestInterface $value): array
    {
        return self::filter([
            self::KEY_MODE_ID => $value->getModeId(),
            self::KEY_ACTION_ID => $value->getActionId(),
            self::KEY_MODE_NAME => $value->getModeName(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSceneSleepRequest(SceneSleepRequestInterface $value): array
    {
        return self::filter([
            self::KEY_SECONDS => $value->getSeconds(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSleepAction(SleepActionInterface $value): array
    {
        return self::filter([
            self::KEY_DURATION => self::serializeInterval($value->getDuration()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeTimeOperand(TimeOperandInterface $value): array
    {
        return self::filter([
            self::KEY_TIME_ZONE_ID => $value->getTimeZoneId(),
            self::KEY_DAYS_OF_WEEK => $value->getDaysOfWeek(),
            self::KEY_REFERENCE => $value->getReference(),
            self::KEY_OFFSET => self::serializeOptionalInterval($value->getOffset()),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeToggleAction(ToggleActionInterface $value): array
    {
        return self::filter([
            self::KEY_DEVICES => $value->getDevices(),
            self::KEY_COMPONENT => $value->getComponent(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeWasCondition(WasConditionInterface $value): array
    {
        return self::filter([
            self::KEY_AND => self::serializeConditionList($value->getAnd()),
            self::KEY_OR => self::serializeConditionList($value->getOr()),
            self::KEY_NOT => self::serializeOptionalCondition($value->getNot()),
            self::KEY_EQUALS => self::serializeOptionalEqualsCondition($value->getEquals()),
            self::KEY_GREATER_THAN => self::serializeOptionalGreaterThanCondition($value->getGreaterThan()),
            self::KEY_GREATER_THAN_OR_EQUALS => self::serializeOptionalGreaterThanOrEqualsCondition($value->getGreaterThanOrEquals()),
            self::KEY_LESS_THAN => self::serializeOptionalLessThanCondition($value->getLessThan()),
            self::KEY_LESS_THAN_OR_EQUALS => self::serializeOptionalLessThanOrEqualsCondition($value->getLessThanOrEquals()),
            self::KEY_BETWEEN => self::serializeOptionalBetweenCondition($value->getBetween()),
            self::KEY_ID => $value->getId(),
            self::KEY_DURATION => self::serializeInterval($value->getDuration()),
            self::KEY_OPERAND => self::serializeOptionalOperand($value->getOperand()),
        ]);
    }
}
