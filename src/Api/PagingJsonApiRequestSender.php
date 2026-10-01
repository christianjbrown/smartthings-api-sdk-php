<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Multipart\MultipartPartInterface;

use function array_intersect_key;
use function array_merge;
use function is_array;
use function is_string;

final class PagingJsonApiRequestSender implements PagingJsonApiRequestSenderInterface
{
    private int $maxPages;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, int $maxPages)
    {
        $this->requestSender = $requestSender;
        $this->maxPages = $maxPages;
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     *
     * @return array<array-key, mixed>
     */
    public function delete(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = []): array
    {
        return $this->requestSender->delete($requestUrl, $requestQueryStrings, $requestHeaders);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     *
     * @return array<array-key, mixed>
     */
    public function get(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = []): array
    {
        $response = $this->requestSender->get($requestUrl, $requestQueryStrings, $requestHeaders);

        return $this->followNextPages($response, $requestHeaders, 1);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function patch(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->patch($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function patchForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->patchForm($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function patchMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->patchMultipart($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function post(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->post($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function postForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->postForm($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function postMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->postMultipart($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function put(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->put($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function putForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->putForm($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function putMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->putMultipart($requestUrl, $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    /**
     * @param array<array-key, mixed> $response
     * @param array<string, string>   $requestHeaders
     *
     * @return array<array-key, mixed>
     */
    private function followNextPages(array $response, array $requestHeaders, int $page): array
    {
        $items = self::itemsOf($response);
        if (null === $items) {
            return $response;
        }
        $next = self::nextHref($response);
        if (null === $next) {
            return $response;
        }
        if ($page >= $this->maxPages) {
            return $response;
        }

        $following = $this->requestSender->get($next, [], $requestHeaders);
        $followingItems = self::itemsOf($following);
        if (null === $followingItems) {
            return $response;
        }

        return $this->followNextPages(self::merge($response, array_merge($items, $followingItems), $following), $requestHeaders, $page + 1);
    }

    /**
     * @param array<array-key, mixed> $response
     *
     * @return null|array<array-key, mixed>
     */
    private static function itemsOf(array $response): ?array
    {
        $items = $response[self::KEY_ITEMS] ?? null;

        return is_array($items) ? $items : null;
    }

    /**
     * @param array<array-key, mixed> $response
     * @param array<array-key, mixed> $items     Every item read so far
     * @param array<array-key, mixed> $following The page just read, whose links replace the response's
     *
     * @return array<array-key, mixed>
     */
    private static function merge(array $response, array $items, array $following): array
    {
        $merged = array_merge($response, [self::KEY_ITEMS => $items]);
        unset($merged[self::KEY_LINKS]);

        return array_merge($merged, array_intersect_key($following, [self::KEY_LINKS => true]));
    }

    /**
     * The address of the next page, or null when the response is on its last page.
     *
     * @param array<array-key, mixed> $response
     */
    private static function nextHref(array $response): ?string
    {
        $links = $response[self::KEY_LINKS] ?? null;
        if (!is_array($links)) {
            return null;
        }
        $next = $links[self::KEY_NEXT] ?? null;
        if (!is_array($next)) {
            return null;
        }
        $href = $next[self::KEY_HREF] ?? null;
        if (!is_string($href)) {
            return null;
        }
        if ('' === $href) {
            return null;
        }

        return $href;
    }
}
