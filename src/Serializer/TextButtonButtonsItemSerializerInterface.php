<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;

interface TextButtonButtonsItemSerializerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_LABEL = 'label';
    public const string KEY_STATE = 'state';

    /**
     * @return mixed[]
     */
    public function serialize(TextButtonButtonsItemInterface $model): array;
}
