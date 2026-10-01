<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformer;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class TextToSpeechShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_TTS_VOICE_TRANSFORMER, TtsVoiceTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_TTS_INFO_TRANSFORMER, TtsInfoTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_TTS_VOICE_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_CONVERTED_TTS_TRANSFORMER, ConvertedTtsTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_PLAYED_TEXT_TRANSFORMER, PlayedTextTransformer::class);
    }
}
