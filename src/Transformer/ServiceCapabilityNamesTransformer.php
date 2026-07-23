<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function is_string;
use function sprintf;

final class ServiceCapabilityNamesTransformer implements ServiceCapabilityNamesTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return array<int, string>
     */
    public function transform(array $data): array
    {
        // The response wraps the capability names in a `name` array; an empty
        // array is a valid result (a location without geo-coordinates has no
        // service capabilities), hence the isset/is_array guard rather than empty().
        if (!isset($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_NAME));
        }
        if (!is_array($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_NAME));
        }

        $names = [];
        $values = array_values($data[self::KEY_NAME]);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            if (!is_string($values[$i])) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::ARRAY_NAME));
            }
            $names[] = $values[$i];
        }

        return $names;
    }
}
