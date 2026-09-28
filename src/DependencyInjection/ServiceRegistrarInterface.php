<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void;
}
