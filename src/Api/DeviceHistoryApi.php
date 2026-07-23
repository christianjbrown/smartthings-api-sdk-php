<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformerInterface;

use function array_merge;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class DeviceHistoryApi implements DeviceHistoryApiInterface
{
    /**
     * @var array<string, array<int, DeviceHistoryEventInterface>>
     */
    private array $cache = [];
    private DeviceHistoryEventsTransformerInterface $deviceHistoryEventsTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceHistoryEventsTransformerInterface $deviceHistoryEventsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->deviceHistoryEventsTransformer = $deviceHistoryEventsTransformer;
        $this->token = $token;
    }

    /**
     * Reads device event history, transparently following the paging
     * `_links.next.href` and aggregating every page's `items` until the API
     * stops returning a next link or the optional $maxPages cap is reached
     * (null means no cap). An empty `items` array is a valid, non-error result.
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceHistoryEventInterface>
     */
    public function getMultiple(?string $deviceId = null, ?string $locationId = null, bool $oldestFirst = false, ?int $maxPages = null, bool $skipCache = false): array
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, (string) $deviceId, (string) $locationId, (string) (int) $oldestFirst, (string) $maxPages);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $rawItems = $this->collectPages(self::buildQuery($deviceId, $locationId, $oldestFirst), self::API_URL, 0, $maxPages);
        $events = $this->deviceHistoryEventsTransformer->transform($rawItems);
        $this->cache[$cacheKey] = $events;

        return $events;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?string $deviceId, ?string $locationId, bool $oldestFirst): array
    {
        // Only the filters the caller supplied are added; oldestFirst defaults
        // to false on the server, so it is only sent when explicitly requested.
        $query = [];
        if (null !== $deviceId) {
            $query[self::KEY_DEVICE_ID] = $deviceId;
        }
        if (null !== $locationId) {
            $query[self::KEY_LOCATION_ID] = $locationId;
        }
        if ($oldestFirst) {
            $query[self::KEY_OLDEST_FIRST] = self::OLDEST_FIRST_TRUE;
        }

        return $query;
    }

    /**
     * Fetches one page and, while a next link remains and the page cap has not
     * been reached, recurses into the next page — the next href is an absolute
     * URL that already carries the paging query, so recursion sends no query.
     *
     * @param array<string, string> $query
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function collectPages(array $query, string $url, int $page, ?int $maxPages): array
    {
        $result = $this->fetchPage($query, $url);

        $next = self::nextUrl($result['nextHref'], $page + 1, $maxPages);
        if (null === $next) {
            return $result['items'];
        }

        return array_merge($result['items'], $this->collectPages([], $next, $page + 1, $maxPages));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function extractNextHref(array $data): ?string
    {
        if (!isset($data[self::KEY_LINKS])) {
            return null;
        }
        if (!is_array($data[self::KEY_LINKS])) {
            return null;
        }
        $links = $data[self::KEY_LINKS];
        if (!isset($links[self::KEY_NEXT])) {
            return null;
        }
        if (!is_array($links[self::KEY_NEXT])) {
            return null;
        }
        $next = $links[self::KEY_NEXT];
        if (empty($next[self::KEY_HREF])) {
            return null;
        }
        if (!is_string($next[self::KEY_HREF])) {
            return null;
        }

        return $next[self::KEY_HREF];
    }

    /**
     * @param array<string, string> $query
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array{items: list<mixed>, nextHref: ?string}
     */
    private function fetchPage(array $query, string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, $query, $headers);

        if (!isset($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }

        return [
            'items' => array_values($data[self::KEY_ITEMS]),
            'nextHref' => self::extractNextHref($data),
        ];
    }

    /**
     * Returns the next page URL, or null when the page cap has been reached or
     * the response carried no usable next link.
     */
    private static function nextUrl(?string $nextHref, int $page, ?int $maxPages): ?string
    {
        if (null === $maxPages) {
            return $nextHref;
        }
        if ($page >= $maxPages) {
            return null;
        }

        return $nextHref;
    }
}
