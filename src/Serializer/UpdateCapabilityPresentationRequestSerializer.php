<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequestInterface;

use function array_filter;

final class UpdateCapabilityPresentationRequestSerializer implements UpdateCapabilityPresentationRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateCapabilityPresentationRequestInterface $request): array
    {
        return self::filter([
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
