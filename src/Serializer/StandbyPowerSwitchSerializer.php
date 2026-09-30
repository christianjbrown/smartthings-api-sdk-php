<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

use function array_filter;

final class StandbyPowerSwitchSerializer implements StandbyPowerSwitchSerializerInterface
{
    private StandbyPowerSwitchForDashboardStateSerializerInterface $standbyPowerSwitchForDashboardStateSerializer;
    private ToggleSwitchForDashboardCommandSerializerInterface $toggleSwitchForDashboardCommandSerializer;

    public function __construct(ToggleSwitchForDashboardCommandSerializerInterface $toggleSwitchForDashboardCommandSerializer, StandbyPowerSwitchForDashboardStateSerializerInterface $standbyPowerSwitchForDashboardStateSerializer)
    {
        $this->toggleSwitchForDashboardCommandSerializer = $toggleSwitchForDashboardCommandSerializer;
        $this->standbyPowerSwitchForDashboardStateSerializer = $standbyPowerSwitchForDashboardStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(StandbyPowerSwitchInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $this->serializeOptionalToggleSwitchForDashboardCommand($model->getCommand()),
            self::KEY_STATE => $this->serializeOptionalState($model->getState()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalState(?StandbyPowerSwitchForDashboardStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->standbyPowerSwitchForDashboardStateSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalToggleSwitchForDashboardCommand(?ToggleSwitchForDashboardCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->toggleSwitchForDashboardCommandSerializer->serialize($value);
    }
}
