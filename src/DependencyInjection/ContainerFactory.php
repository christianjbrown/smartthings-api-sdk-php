<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection;

use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\TokenInterface;
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
use ChristianBrown\SmartThings\DependencyInjection\Registrar\TreeRegistrar;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_map;

final class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * @var list<ServiceRegistrarInterface>
     */
    private array $registrars;

    public function __construct(TokenInterface $token, ApiHostInterface $apiHost)
    {
        // Registration order matters: a service must be registered before another
        // service wires a reference to its definition, so core comes first and the
        // API clients (which reference every transformer chain) come last.
        $this->registrars = [
            new CoreRegistrar($apiHost),
            new TreeRegistrar(),
            new ShapeRegistrar(),
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
            new ApiClientRegistrar($token),
        ];
    }

    public function build(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        array_map(
            static function (ServiceRegistrarInterface $registrar) use ($container): void {
                $registrar->register($container);
            },
            $this->registrars
        );

        return $container;
    }
}
