<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\QueryParametersInterface;

use function array_filter;
use function array_keys;
use function array_map;
use function array_merge;
use function implode;
use function is_bool;
use function rawurlencode;
use function sprintf;

final class RequestUrlBuilder implements RequestUrlBuilderInterface
{
    /**
     * @param string                                                 $baseUrl    The URL without a query
     * @param array<string, null|array<int, string>|bool|int|string> $parameters Explicit parameters
     * @param null|QueryParametersInterface                          $query      Parameters carried by a query object
     */
    public function build(string $baseUrl, array $parameters = [], ?QueryParametersInterface $query = null): string
    {
        $merged = array_merge(self::parametersOf($query), self::present($parameters));
        $present = self::present($merged);
        $pairs = array_merge([], ...array_map(static fn (string $name, array|bool|int|string $value): array => self::pairsFor($name, $value), array_keys($present), $present));

        return [] === $pairs ? $baseUrl : $baseUrl.self::QUERY_SEPARATOR.implode(self::PAIR_SEPARATOR, $pairs);
    }

    /**
     * @param string                             $name  The parameter name
     * @param array<int, string>|bool|int|string $value The parameter value
     *
     * @return array<int, string>
     */
    private static function pairsFor(string $name, array|bool|int|string $value): array
    {
        return array_map(
            static fn (bool|int|string $item): string => sprintf(self::PAIR_SPRINTF, rawurlencode($name), rawurlencode(self::text($item))),
            (array) $value
        );
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    private static function parametersOf(?QueryParametersInterface $query): array
    {
        return null === $query ? [] : $query->getParameters();
    }

    /**
     * @param array<string, null|array<int, string>|bool|int|string> $parameters
     *
     * @return array<string, array<int, string>|bool|int|string>
     */
    private static function present(array $parameters): array
    {
        return array_filter($parameters, static fn (mixed $value): bool => null !== $value);
    }

    private static function text(bool|int|string $value): string
    {
        if (is_bool($value)) {
            return $value ? self::BOOLEAN_TRUE : self::BOOLEAN_FALSE;
        }

        return (string) $value;
    }
}
