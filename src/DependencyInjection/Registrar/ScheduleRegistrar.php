<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\ScheduleRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ScheduleRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_REQUEST_SERIALIZER, ScheduleRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULE_TRANSFORMER, ScheduleTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_SCHEDULES_TRANSFORMER, SchedulesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_SCHEDULE_TRANSFORMER),
                ]
            );
    }
}
