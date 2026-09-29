<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetailsInterface;

interface ServiceCapabilityDataDetailsTransformerInterface
{
    public const string KEY_ALERT = 'alert';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataDetailsInterface;
}
