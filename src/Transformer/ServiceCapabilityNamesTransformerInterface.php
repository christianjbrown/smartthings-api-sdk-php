<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

interface ServiceCapabilityNamesTransformerInterface
{
    public const string ARRAY_NAME = 'capabilityName';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array;
}
