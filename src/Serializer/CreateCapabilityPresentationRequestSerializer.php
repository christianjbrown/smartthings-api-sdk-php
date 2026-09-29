<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestInterface;

use function array_filter;

final class CreateCapabilityPresentationRequestSerializer implements CreateCapabilityPresentationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateCapabilityPresentationRequestInterface $request): array
    {
        return self::filter([
            self::KEY_ID => $request->getId(),
            self::KEY_VERSION => $request->getVersion(),
            self::KEY_DASHBOARD => $request->getDashboard(),
            self::KEY_DETAIL_VIEW => $request->getDetailView(),
            self::KEY_AUTOMATION => $request->getAutomation(),
            self::KEY_PRESENTATION_SETTINGS => $request->getPresentationSettings(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
