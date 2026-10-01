<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface SmartThingsFactoryInterface
{
    /**
     * Builds a client for the production SmartThings API.
     */
    public function create(string $apiToken): SmartThingsInterface;

    /**
     * Builds the container behind the facade, for code that needs a service the facade does not expose.
     */
    public function createContainer(string $apiToken, ApiHostInterface $apiHost): ContainerBuilder;

    /**
     * Builds a client that sends every request to the given host instead of production.
     */
    public function createForHost(string $apiToken, ApiHostInterface $apiHost): SmartThingsInterface;
}
