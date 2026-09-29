<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;

use function array_filter;

final class BasicPlusLightColorControlSerializer implements BasicPlusLightColorControlSerializerInterface
{
    private BasicPlusLightColorControlColorSerializerInterface $basicPlusLightColorControlColorSerializer;

    public function __construct(BasicPlusLightColorControlColorSerializerInterface $basicPlusLightColorControlColorSerializer)
    {
        $this->basicPlusLightColorControlColorSerializer = $basicPlusLightColorControlColorSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightColorControlInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_COLOR => $this->basicPlusLightColorControlColorSerializer->serialize($model->getColor()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
