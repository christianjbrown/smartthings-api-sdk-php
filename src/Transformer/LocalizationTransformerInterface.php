<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocalizationInterface;

interface LocalizationTransformerInterface
{
    public const array DETAIL_KEYS = [self::KEY_OPTIONS, self::KEY_ATTRIBUTES, self::KEY_COMMANDS];
    public const string KEY_ATTRIBUTES = 'attributes';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_LABEL = 'label';
    public const string KEY_OPTIONS = 'options';
    public const string KEY_TAG = 'tag';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocalizationInterface;
}
