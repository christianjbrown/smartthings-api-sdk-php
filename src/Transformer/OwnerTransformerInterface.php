<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\OwnerInterface;

interface OwnerTransformerInterface
{
    public const string KEY_OWNER_ID = 'ownerId';
    public const string KEY_OWNER_TYPE = 'ownerType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OwnerInterface;
}
