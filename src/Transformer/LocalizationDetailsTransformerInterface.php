<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocalizationDetailsInterface;

interface LocalizationDetailsTransformerInterface
{
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_OPTIONS = 'options';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocalizationDetailsInterface;
}
