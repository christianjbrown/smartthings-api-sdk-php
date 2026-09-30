<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SecurityStateInterface;

interface SecurityStateTransformerInterface
{
    public const string KEY_ARM_STATE = 'armState';
    public const string KEY_MONITORING = 'monitoring';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SecurityStateInterface;
}
