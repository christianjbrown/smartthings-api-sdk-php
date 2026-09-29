<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TtsInfoInterface;

interface TtsInfoTransformerInterface
{
    public const string KEY_VOICES = 'voices';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TtsInfoInterface;
}
