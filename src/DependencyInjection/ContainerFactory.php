<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_map;

final class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * @var list<ServiceRegistrarInterface>
     */
    private array $registrars;

    /**
     * @param list<ServiceRegistrarInterface> $registrars run in order: a service must be registered
     *                                                    before another one wires its definition
     */
    public function __construct(array $registrars)
    {
        $this->registrars = $registrars;
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
