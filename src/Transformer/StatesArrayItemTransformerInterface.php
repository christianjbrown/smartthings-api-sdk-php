<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StatesArrayItemInterface;

interface StatesArrayItemTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_COMPOSITE = 'composite';
    public const string KEY_FORMAT_INFO = 'formatInfo';
    public const string KEY_GROUP = 'group';
    public const string KEY_LABEL = 'label';
    public const string KEY_TRANSIENT = 'transient';
    public const string KEY_VERSION = 'version';
    public const string KEY_VISIBLE_CONDITION = 'visibleCondition';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StatesArrayItemInterface;
}
