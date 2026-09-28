<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CreateInstalledAppEventsRequestInterface;
use ChristianBrown\SmartThings\Model\SmartAppDashboardCardEventRequestInterface;
use ChristianBrown\SmartThings\Model\SmartAppEventRequestInterface;

use function array_filter;
use function array_map;

final class CreateInstalledAppEventsRequestSerializer implements CreateInstalledAppEventsRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateInstalledAppEventsRequestInterface $request): array
    {
        return self::filter([
            self::KEY_SMART_APP_EVENTS => self::serializeSmartAppEventRequestList($request->getSmartAppEvents()),
            self::KEY_SMART_APP_DASHBOARD_CARD_EVENTS => self::serializeSmartAppDashboardCardEventRequestList($request->getSmartAppDashboardCardEvents()),
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

    /**
     * @return mixed[]
     */
    private static function serializeSmartAppDashboardCardEventRequest(SmartAppDashboardCardEventRequestInterface $value): array
    {
        return self::filter([
            self::KEY_CARD_ID => $value->getCardId(),
            self::KEY_LIFECYCLE => $value->getLifecycle(),
        ]);
    }

    /**
     * @param null|array<int, SmartAppDashboardCardEventRequestInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSmartAppDashboardCardEventRequestList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SmartAppDashboardCardEventRequestInterface $item): array => self::serializeSmartAppDashboardCardEventRequest($item), $values);
    }

    /**
     * @return mixed[]
     */
    private static function serializeSmartAppEventRequest(SmartAppEventRequestInterface $value): array
    {
        return self::filter([
            self::KEY_NAME => $value->getName(),
            self::KEY_ATTRIBUTES => $value->getAttributes(),
        ]);
    }

    /**
     * @param null|array<int, SmartAppEventRequestInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private static function serializeSmartAppEventRequestList(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(static fn (SmartAppEventRequestInterface $item): array => self::serializeSmartAppEventRequest($item), $values);
    }
}
