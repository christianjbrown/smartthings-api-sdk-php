<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\RuleRequestInterface;

use function array_filter;
use function array_map;

final class RuleRequestSerializer implements RuleRequestSerializerInterface
{
    private ActionSerializerInterface $actionSerializer;

    public function __construct(ActionSerializerInterface $actionSerializer)
    {
        $this->actionSerializer = $actionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(RuleRequestInterface $request): array
    {
        $serialized = [
            self::KEY_NAME => $request->getName(),
            self::KEY_ACTIONS => $this->serializeActions($request->getActions()),
            self::KEY_SEQUENCE => self::serializeSequence($request->getActionSequence()) ?? $request->getSequence(),
            self::KEY_TIME_ZONE_ID => $request->getTimeZoneId(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * Typed actions are serialized; raw arrays pass through unmodified.
     *
     * @param array<int, ActionInterface|mixed[]> $actions
     *
     * @return array<int, mixed>
     */
    private function serializeActions(array $actions): array
    {
        $serializer = $this->actionSerializer;

        return array_map(static fn (mixed $action): mixed => $action instanceof ActionInterface ? $serializer->serialize($action) : $action, $actions);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeSequence(?ActionSequenceInterface $sequence): ?array
    {
        if (null === $sequence) {
            return null;
        }

        return array_filter([self::KEY_ACTIONS => $sequence->getActions()], static fn (mixed $value): bool => null !== $value);
    }
}
