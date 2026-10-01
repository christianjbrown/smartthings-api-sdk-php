<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\Registrar\BasicPlusShapeRegistrar;
use ChristianBrown\SmartThings\SmartThingsInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(BasicPlusShapeRegistrar::class)]
final class BasicPlusShapeRegistrarTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new ContainerBuilder();

        (new BasicPlusShapeRegistrar())->register($container);
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER));
        self::assertTrue($container->hasDefinition(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER));
    }
}
