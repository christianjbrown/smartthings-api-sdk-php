<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface QueryParametersInterface
{
    /**
     * The query parameters this object stands for, keyed by the name the API
     * expects. Unset parameters are null; list values are sent as repeated
     * parameters.
     *
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array;
}
