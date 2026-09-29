<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInlineInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardActionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;

final class DeviceConfigEntryForDashboardActionSerializer implements DeviceConfigEntryForDashboardActionSerializerInterface
{
    private DeviceConfigEntryForDashboardActionInlineSerializerInterface $deviceConfigEntryForDashboardActionInlineSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(DeviceConfigEntryForDashboardActionInlineSerializerInterface $deviceConfigEntryForDashboardActionInlineSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->deviceConfigEntryForDashboardActionInlineSerializer = $deviceConfigEntryForDashboardActionInlineSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigEntryForDashboardActionInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_IDX => $model->getIdx(),
            self::KEY_GROUP => $model->getGroup(),
            self::KEY_INLINE => $this->serializeOptionalInline($model->getInline()),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalInline(?DeviceConfigEntryForDashboardActionInlineInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->deviceConfigEntryForDashboardActionInlineSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionSerializer->serialize($value);
    }
}
