<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleDetailsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ScheduleShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_CRON_SCHEDULE_TRANSFORMER, CronScheduleTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_DETAILS_TRANSFORMER, ScheduleDetailsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_CRON_SCHEDULE_TRANSFORMER),
                ]
            );
    }
}
