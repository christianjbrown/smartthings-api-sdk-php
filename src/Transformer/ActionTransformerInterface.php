<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;

interface ActionTransformerInterface
{
    public const string KEY_ACTION_ID = 'actionId';
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_AGGREGATION = 'aggregation';
    public const string KEY_AND = 'and';
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_ARRAY = 'array';
    public const string KEY_ATTRIBUTE = 'attribute';
    public const string KEY_BETWEEN = 'between';
    public const string KEY_BOOLEAN = 'boolean';
    public const string KEY_CAPABILITIES = 'capabilities';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_CAPABILITY_ID = 'capabilityId';
    public const string KEY_CHANGES = 'changes';
    public const string KEY_CHANGES_ONLY = 'changesOnly';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMMAND_ID = 'commandId';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_COMPONENT_ID = 'componentId';
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_COUNT = 'count';
    public const string KEY_DATE = 'date';
    public const string KEY_DATETIME = 'datetime';
    public const string KEY_DAY = 'day';
    public const string KEY_DAYS_OF_WEEK = 'daysOfWeek';
    public const string KEY_DECIMAL = 'decimal';
    public const string KEY_DEVICE = 'device';
    public const string KEY_DEVICE_GROUP_ID = 'deviceGroupId';
    public const string KEY_DEVICE_GROUP_REQUEST = 'deviceGroupRequest';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_DEVICE_REQUEST = 'deviceRequest';
    public const string KEY_DEVICES = 'devices';
    public const string KEY_DURATION = 'duration';
    public const string KEY_ELSE = 'else';
    public const string KEY_END = 'end';
    public const string KEY_EQUALS = 'equals';
    public const string KEY_EVERY = 'every';
    public const string KEY_GREATER_THAN = 'greaterThan';
    public const string KEY_GREATER_THAN_OR_EQUALS = 'greaterThanOrEquals';
    public const string KEY_ID = 'id';
    public const string KEY_IF = 'if';
    public const string KEY_INTEGER = 'integer';
    public const string KEY_INTERVAL = 'interval';
    public const string KEY_LATCHING = 'latching';
    public const string KEY_LEFT = 'left';
    public const string KEY_LESS_THAN = 'lessThan';
    public const string KEY_LESS_THAN_OR_EQUALS = 'lessThanOrEquals';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_LOCATION = 'location';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_MAP = 'map';
    public const string KEY_MODE = 'mode';
    public const string KEY_MODE_ID = 'modeId';
    public const string KEY_MODE_NAME = 'modeName';
    public const string KEY_MODE_REQUEST = 'modeRequest';
    public const string KEY_MONTH = 'month';
    public const string KEY_NAME = 'name';
    public const string KEY_NOT = 'not';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_OPERAND = 'operand';
    public const string KEY_OPERANDS = 'operands';
    public const string KEY_OR = 'or';
    public const string KEY_PATH = 'path';
    public const string KEY_PERIOD = 'period';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_REFERENCE = 'reference';
    public const string KEY_REMAINS = 'remains';
    public const string KEY_RIGHT = 'right';
    public const string KEY_SCENE = 'scene';
    public const string KEY_SCHEMA = 'schema';
    public const string KEY_SECONDS = 'seconds';
    public const string KEY_SEQUENCE = 'sequence';
    public const string KEY_SLEEP = 'sleep';
    public const string KEY_SLEEP_REQUEST = 'sleepRequest';
    public const string KEY_SPECIFIC = 'specific';
    public const string KEY_START = 'start';
    public const string KEY_STATUS = 'status';
    public const string KEY_STRING = 'string';
    public const string KEY_THEN = 'then';
    public const string KEY_TIME = 'time';
    public const string KEY_TIME_ZONE_ID = 'timeZoneId';
    public const string KEY_TOGGLE = 'toggle';
    public const string KEY_TRIGGER = 'trigger';
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string KEY_WAS = 'was';
    public const string KEY_YEAR = 'year';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionInterface;

    /**
     * @param mixed[] $data
     */
    public function transformActionSequence(array $data): ActionSequenceInterface;

    /**
     * Transforms a list of Action objects, skipping entries that are not arrays.
     *
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    public function transformAll(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionSequenceInterface>
     */
    public function transformAllActionSequence(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionInterface>
     */
    public function transformMap(array $data): array;

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionSequenceInterface>
     */
    public function transformMapActionSequence(array $data): array;
}
