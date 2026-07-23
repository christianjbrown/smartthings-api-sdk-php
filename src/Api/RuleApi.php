<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Transformer\RulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class RuleApi implements RuleApiInterface
{
    /**
     * @var array<string, RuleInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, RuleInterface>>
     */
    private array $listCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private RulesTransformerInterface $rulesTransformer;
    private RuleTransformerInterface $ruleTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, RuleTransformerInterface $ruleTransformer, RulesTransformerInterface $rulesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->ruleTransformer = $ruleTransformer;
        $this->rulesTransformer = $rulesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws MissingInputException
     * @throws UnexpectedResponseException
     *
     * @return array<int, RuleInterface>
     */
    public function getMultiple(string $locationId, bool $skipCache = false): array
    {
        if ('' === $locationId) {
            throw new MissingInputException(self::MISSING_LOCATION_ID);
        }
        if (!$skipCache) {
            if (isset($this->listCache[$locationId])) {
                return $this->listCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $query = [self::KEY_LOCATION_ID => $locationId];
        $data = $this->requestSender->get(self::API_URL, $query, $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $rules = $this->rulesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$locationId] = $rules;

        return $rules;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws MissingInputException
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $ruleId, string $locationId, bool $skipCache = false): RuleInterface
    {
        if ('' === $locationId) {
            throw new MissingInputException(self::MISSING_LOCATION_ID);
        }
        if (!$skipCache) {
            if (isset($this->cache[$ruleId])) {
                return $this->cache[$ruleId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($ruleId));
        $query = [self::KEY_LOCATION_ID => $locationId];
        $data = $this->requestSender->get($url, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $rule = $this->ruleTransformer->transform($data);
        $this->cache[$ruleId] = $rule;

        return $rule;
    }
}
