<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ScheduleInterface;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class ScheduleApi implements ScheduleApiInterface
{
    /**
     * @var array<string, ScheduleInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, ScheduleInterface>>
     */
    private array $listCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private SchedulesTransformerInterface $schedulesTransformer;
    private ScheduleTransformerInterface $scheduleTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ScheduleTransformerInterface $scheduleTransformer, SchedulesTransformerInterface $schedulesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->scheduleTransformer = $scheduleTransformer;
        $this->schedulesTransformer = $schedulesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ScheduleInterface>
     */
    public function getMultiple(string $installedAppId, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->listCache[$installedAppId])) {
                return $this->listCache[$installedAppId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($installedAppId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $schedules = $this->schedulesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$installedAppId] = $schedules;

        return $schedules;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByName(string $installedAppId, string $scheduleName, bool $skipCache = false): ScheduleInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $installedAppId, $scheduleName);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($installedAppId), rawurlencode($scheduleName));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $schedule = $this->scheduleTransformer->transform($data);
        $this->cache[$cacheKey] = $schedule;

        return $schedule;
    }
}
