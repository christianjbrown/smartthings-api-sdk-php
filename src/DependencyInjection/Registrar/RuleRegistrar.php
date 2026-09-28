<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RuleRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_RULE_EXECUTION_RESULT_TRANSFORMER, RuleExecutionResultTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_RULE_REQUEST_SERIALIZER, RuleRequestSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_RULE_TRANSFORMER, RuleTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_RULES_TRANSFORMER, RulesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULE_TRANSFORMER),
                ]
            );
    }
}
