<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\BehaviorAbnormalExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\CommandActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\IfActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\LocationActionExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityStateTransformer;
use ChristianBrown\SmartThings\Transformer\SleepActionExecutionResultTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RuleRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_SECURITY_STATE_TRANSFORMER, SecurityStateTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_BEHAVIOR_ABNORMAL_EXECUTION_RESULT_TRANSFORMER, BehaviorAbnormalExecutionResultTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_IF_ACTION_EXECUTION_RESULT_TRANSFORMER, IfActionExecutionResultTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_SLEEP_ACTION_EXECUTION_RESULT_TRANSFORMER, SleepActionExecutionResultTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_COMMAND_ACTION_EXECUTION_RESULT_TRANSFORMER, CommandActionExecutionResultTransformer::class)
            ->setArguments([new Reference(SmartThingsInterface::SERVICE_VALUE_READER)]);
        $container->register(SmartThingsInterface::SERVICE_LOCATION_ACTION_EXECUTION_RESULT_TRANSFORMER, LocationActionExecutionResultTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                    new Reference(SmartThingsInterface::SERVICE_SECURITY_STATE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_ACTION_EXECUTION_RESULT_TRANSFORMER, ActionExecutionResultTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                    new Reference(SmartThingsInterface::SERVICE_IF_ACTION_EXECUTION_RESULT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_LOCATION_ACTION_EXECUTION_RESULT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_COMMAND_ACTION_EXECUTION_RESULT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_SLEEP_ACTION_EXECUTION_RESULT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BEHAVIOR_ABNORMAL_EXECUTION_RESULT_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RULE_EXECUTION_RESULT_TRANSFORMER, RuleExecutionResultTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ACTION_EXECUTION_RESULT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VALUE_READER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RULE_REQUEST_SERIALIZER, RuleRequestSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ACTION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RULE_TRANSFORMER, RuleTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ACTION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_RULES_TRANSFORMER, RulesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(SmartThingsInterface::SERVICE_RULE_TRANSFORMER),
                ]
            );
    }
}
