<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

interface HubCharacteristicsTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<string, bool|float|int|string>
     */
    public function transform(array $data): array;
}
