<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\DependencyInjection\ContainerFactory;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ApiClientRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\AppRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\AppShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\BasicPlusShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityAutomationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityLocalizationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityPresentationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ChannelRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CoreRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceConfigurationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceHealthRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceHistoryRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePreferenceDefinitionRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePreferenceRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePresentationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceProfileRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceProfileShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceStatusRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DriverRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DriverShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\HubRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\I18nRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\InstalledAppRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\LocationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\LocationShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ModeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\OrganizationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\PresentationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\RuleRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SceneRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ScheduleRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ScheduleShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SchemaAppInviteShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SchemaAppShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SchemaConnectorRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ServiceApiRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ServiceShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SubscriptionRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SubscriptionShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\TextToSpeechShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\TreeRegistrar;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * The composition root: the one place the default object graph behind the SmartThings facade is built.
 */
final class SmartThingsFactory implements SmartThingsFactoryInterface
{
    public function create(string $apiToken): SmartThingsInterface
    {
        return $this->createForHost($apiToken, new ApiHost());
    }

    public function createContainer(string $apiToken, ApiHostInterface $apiHost): ContainerBuilder
    {
        // Registration order matters: a service must be registered before another
        // service wires a reference to its definition, so core comes first and the
        // API clients (which reference every transformer chain) come last.
        $containerFactory = new ContainerFactory(
            [
                new CoreRegistrar($apiHost),
                new TreeRegistrar(),
                new TextToSpeechShapeRegistrar(),
                new SchemaAppInviteShapeRegistrar(),
                new LocationShapeRegistrar(),
                new ScheduleShapeRegistrar(),
                new ServiceShapeRegistrar(),
                new DriverShapeRegistrar(),
                new SchemaAppShapeRegistrar(),
                new SubscriptionShapeRegistrar(),
                new AppShapeRegistrar(),
                new DeviceProfileShapeRegistrar(),
                new DeviceShapeRegistrar(),
                new CapabilityLocalizationShapeRegistrar(),
                new CapabilityShapeRegistrar(),
                new DevicePresentationShapeRegistrar(),
                new BasicPlusShapeRegistrar(),
                new DeviceConfigurationShapeRegistrar(),
                new CapabilityAutomationShapeRegistrar(),
                new CapabilityPresentationShapeRegistrar(),
                new AppRegistrar(),
                new CapabilityRegistrar(),
                new ChannelRegistrar(),
                new DeviceRegistrar(),
                new DeviceHealthRegistrar(),
                new DeviceHistoryRegistrar(),
                new DevicePreferenceDefinitionRegistrar(),
                new DevicePreferenceRegistrar(),
                new DeviceProfileRegistrar(),
                new DeviceStatusRegistrar(),
                new DriverRegistrar(),
                new HubRegistrar(),
                new InstalledAppRegistrar(),
                new I18nRegistrar(),
                new LocationRegistrar(),
                new ModeRegistrar(),
                new OrganizationRegistrar(),
                new PresentationRegistrar(),
                new RuleRegistrar(),
                new SceneRegistrar(),
                new ScheduleRegistrar(),
                new SchemaConnectorRegistrar(),
                new ServiceApiRegistrar(),
                new SubscriptionRegistrar(),
                new ApiClientRegistrar(new Token($apiToken)),
            ]
        );

        return $containerFactory->build();
    }

    public function createForHost(string $apiToken, ApiHostInterface $apiHost): SmartThingsInterface
    {
        return new SmartThings($this->createContainer($apiToken, $apiHost));
    }
}
