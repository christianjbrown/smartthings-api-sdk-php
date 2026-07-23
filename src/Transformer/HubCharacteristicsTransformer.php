<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use function array_keys;
use function count;
use function is_scalar;

final class HubCharacteristicsTransformer implements HubCharacteristicsTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<string, bool|float|int|string>
     */
    public function transform(array $data): array
    {
        // The characteristics response is an arbitrary key => value map, so the
        // field names are kept as-is and only scalar values are surfaced; any
        // nested (non-scalar) characteristic is skipped.
        $characteristics = [];
        $names = array_keys($data);
        for ($i = 0, $count = count($names); $i < $count; ++$i) {
            $value = $data[$names[$i]];
            if (is_scalar($value)) {
                $characteristics[(string) $names[$i]] = $value;
            }
        }

        return $characteristics;
    }
}
