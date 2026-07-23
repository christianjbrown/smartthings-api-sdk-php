<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RuleInterface;

interface RulesTransformerInterface
{
    public const string ARRAY_NAME = 'rule';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, RuleInterface>
     */
    public function transform(array $data): array;
}
