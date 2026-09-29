<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection;

use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\Api\HostOverridingJsonApiRequestSender;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\DependencyInjection\ContainerFactory;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ApiClientRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\AppRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CapabilityRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ChannelRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\CoreRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceHealthRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceHistoryRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePreferenceDefinitionRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DevicePreferenceRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceProfileRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DeviceStatusRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\DriverRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\HubRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\I18nRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\InstalledAppRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\LocationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ModeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\OrganizationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\PresentationRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\RuleRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SceneRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ScheduleRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SchemaConnectorRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ServiceApiRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\ShapeRegistrar;
use ChristianBrown\SmartThings\DependencyInjection\Registrar\SubscriptionRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContainerFactory::class)]
#[UsesClass(Token::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(HostOverridingJsonApiRequestSender::class)]
#[UsesClass(ApiClientRegistrar::class)]
#[UsesClass(AppRegistrar::class)]
#[UsesClass(CapabilityRegistrar::class)]
#[UsesClass(ChannelRegistrar::class)]
#[UsesClass(CoreRegistrar::class)]
#[UsesClass(ShapeRegistrar::class)]
#[UsesClass(DeviceHealthRegistrar::class)]
#[UsesClass(DeviceHistoryRegistrar::class)]
#[UsesClass(DevicePreferenceDefinitionRegistrar::class)]
#[UsesClass(DevicePreferenceRegistrar::class)]
#[UsesClass(DeviceProfileRegistrar::class)]
#[UsesClass(DeviceRegistrar::class)]
#[UsesClass(DeviceStatusRegistrar::class)]
#[UsesClass(DriverRegistrar::class)]
#[UsesClass(HubRegistrar::class)]
#[UsesClass(I18nRegistrar::class)]
#[UsesClass(InstalledAppRegistrar::class)]
#[UsesClass(LocationRegistrar::class)]
#[UsesClass(ModeRegistrar::class)]
#[UsesClass(OrganizationRegistrar::class)]
#[UsesClass(PresentationRegistrar::class)]
#[UsesClass(RuleRegistrar::class)]
#[UsesClass(SceneRegistrar::class)]
#[UsesClass(ScheduleRegistrar::class)]
#[UsesClass(SchemaConnectorRegistrar::class)]
#[UsesClass(ServiceApiRegistrar::class)]
#[UsesClass(SubscriptionRegistrar::class)]
final class ContainerFactoryTest extends TestCase
{
    public function testBuild(): void
    {
        $container = (new ContainerFactory(new Token('test-token'), new ApiHost()))->build();

        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_API_CLIENT));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_APP_API));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VIRTUAL_DEVICE_API));
    }
}
