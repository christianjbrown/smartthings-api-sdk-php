<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IdLessHealthStateInterface;

interface IdLessHealthStateTransformerInterface
{
    public const string KEY_LAST_UPDATED_DATE = 'lastUpdatedDate';
    public const string KEY_STATE = 'state';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IdLessHealthStateInterface;
}
