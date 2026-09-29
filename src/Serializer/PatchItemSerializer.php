<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PatchItemInterface;

use function array_filter;

final class PatchItemSerializer implements PatchItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PatchItemInterface $model): array
    {
        $serialized = [
            self::KEY_OP => $model->getOp(),
            self::KEY_PATH => $model->getPath(),
            self::KEY_VALUE => $model->getValue(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
