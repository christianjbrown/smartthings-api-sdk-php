<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\QueryParametersInterface;

interface RequestUrlBuilderInterface
{
    public const string BOOLEAN_FALSE = 'false';
    public const string BOOLEAN_TRUE = 'true';
    public const string PAIR_SEPARATOR = '&';
    public const string PAIR_SPRINTF = '%s=%s';
    public const string QUERY_SEPARATOR = '?';

    /**
     * Appends the query to the base URL. The explicit parameters win over
     * those of the query object; null parameters are left out, list values
     * become repeated parameters and booleans become true or false.
     *
     * @param string                                                 $baseUrl    The URL without a query
     * @param array<string, null|array<int, string>|bool|int|string> $parameters Explicit parameters
     * @param null|QueryParametersInterface                          $query      Parameters carried by a query object
     */
    public function build(string $baseUrl, array $parameters = [], ?QueryParametersInterface $query = null): string;
}
