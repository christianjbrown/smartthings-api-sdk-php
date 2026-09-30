<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardInterface;
use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardStateInterface;

use function array_filter;

final class ToggleSwitchForDashboardSerializer implements ToggleSwitchForDashboardSerializerInterface
{
    private ToggleSwitchForDashboardCommandSerializerInterface $toggleSwitchForDashboardCommandSerializer;
    private ToggleSwitchForDashboardStateSerializerInterface $toggleSwitchForDashboardStateSerializer;

    public function __construct(ToggleSwitchForDashboardCommandSerializerInterface $toggleSwitchForDashboardCommandSerializer, ToggleSwitchForDashboardStateSerializerInterface $toggleSwitchForDashboardStateSerializer)
    {
        $this->toggleSwitchForDashboardCommandSerializer = $toggleSwitchForDashboardCommandSerializer;
        $this->toggleSwitchForDashboardStateSerializer = $toggleSwitchForDashboardStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ToggleSwitchForDashboardInterface $model): array
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
    private function serializeOptionalState(?ToggleSwitchForDashboardStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->toggleSwitchForDashboardStateSerializer->serialize($value);
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
