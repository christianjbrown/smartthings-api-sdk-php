<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StateInterface;

interface StateTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';
    public const string KEY_UNIT = 'unit';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StateInterface;
}
