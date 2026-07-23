<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ScheduleInterface;

use function array_values;
use function count;
use function sprintf;

final class SchedulesTransformer implements SchedulesTransformerInterface
{
    private ScheduleTransformerInterface $scheduleTransformer;

    public function __construct(ScheduleTransformerInterface $scheduleTransformer)
    {
        $this->scheduleTransformer = $scheduleTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ScheduleInterface>
     */
    public function transform(array $data): array
    {
        $schedules = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $scheduleData = $values[$i];
            if (!is_array($scheduleData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $schedules[] = $this->scheduleTransformer->transform($scheduleData);
        }

        return $schedules;
    }
}
