<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;

use function array_values;
use function count;
use function sprintf;

final class DeviceHistoryEventsTransformer implements DeviceHistoryEventsTransformerInterface
{
    private DeviceHistoryEventTransformerInterface $deviceHistoryEventTransformer;

    public function __construct(DeviceHistoryEventTransformerInterface $deviceHistoryEventTransformer)
    {
        $this->deviceHistoryEventTransformer = $deviceHistoryEventTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceHistoryEventInterface>
     */
    public function transform(array $data): array
    {
        $events = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $eventData = $values[$i];
            if (!is_array($eventData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $events[] = $this->deviceHistoryEventTransformer->transform($eventData);
        }

        return $events;
    }
}
