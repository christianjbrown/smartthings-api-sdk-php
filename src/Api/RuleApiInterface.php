<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Model\RuleExecutionResultInterface;
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Model\RuleListQueryInterface;
use ChristianBrown\SmartThings\Model\RuleRequestInterface;

interface RuleApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/rules';
    public const string API_URL_EXECUTE_SPRINTF = 'https://api.smartthings.com/v1/rules/execute/%s';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/rules/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string MISSING_LOCATION_ID = 'Location id is required';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a Rule in the given location. Invalidates the cached rule list for
     * this location so a subsequent getMultiple() reflects the new Rule.
     *
     * @throws MissingInputException
     */
    public function createRule(string $locationId, RuleRequestInterface $request): RuleInterface;

    /**
     * Deletes every Rule in a location. Invalidates the cached rule list and every
     * cached individual Rule for this location.
     *
     * @throws MissingInputException
     */
    public function deleteAllRules(string $locationId): void;

    /**
     * Deletes a Rule from the user's account. Invalidates the cached copy of this
     * Rule and the cached rule list for this location.
     *
     * @throws MissingInputException
     */
    public function deleteRule(string $ruleId, string $locationId): void;

    /**
     * Triggers Rule execution, running its actions. This does not cache: every
     * call re-triggers the rule's side effects.
     */
    public function execute(string $ruleId): RuleExecutionResultInterface;

    /**
     * @return array<int, RuleInterface>
     */
    public function getMultiple(string $locationId, bool $skipCache = false, ?RuleListQueryInterface $query = null): array;

    public function getOneById(string $ruleId, string $locationId, bool $skipCache = false): RuleInterface;

    /**
     * Updates a Rule's logic and actions. Refreshes the cached copy of this Rule and
     * invalidates the cached rule list for this location.
     *
     * @throws MissingInputException
     */
    public function updateRule(string $ruleId, string $locationId, RuleRequestInterface $request): RuleInterface;
}
