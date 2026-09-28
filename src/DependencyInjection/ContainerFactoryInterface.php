<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ContainerFactoryInterface
{
    public function build(): ContainerBuilder;
}
