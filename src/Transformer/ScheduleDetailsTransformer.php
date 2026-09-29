<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ScheduleDetails;
use ChristianBrown\SmartThings\Model\ScheduleDetailsInterface;

use function is_array;

final class ScheduleDetailsTransformer implements ScheduleDetailsTransformerInterface
{
    private CronScheduleTransformerInterface $cronScheduleTransformer;

    public function __construct(CronScheduleTransformerInterface $cronScheduleTransformer)
    {
        $this->cronScheduleTransformer = $cronScheduleTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ScheduleDetailsInterface
    {
        $model = new ScheduleDetails();

        $this->applyCron($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCron(ScheduleDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_CRON])) {
            return;
        }
        if (!is_array($data[self::KEY_CRON])) {
            return;
        }
        $model->setCron($this->cronScheduleTransformer->transform($data[self::KEY_CRON]));
    }
}
