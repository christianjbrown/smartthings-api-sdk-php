<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PoCodesInterface;

interface PoCodesTransformerInterface
{
    public const string KEY_LABEL = 'label';
    public const string KEY_PO = 'po';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PoCodesInterface;
}
