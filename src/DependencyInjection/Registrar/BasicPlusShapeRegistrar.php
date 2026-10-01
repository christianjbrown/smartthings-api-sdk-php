<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\DependencyInjection\Registrar;

use ChristianBrown\SmartThings\DependencyInjection\ServiceRegistrarInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraImageSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraOverlayIconsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemActionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemProgressBarsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlColorSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightColorControlSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusLightSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsBarItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsStateItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardColorsSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvChannelSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvDirectionalPadSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeCommandSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusTvVolumeSerializer;
use ChristianBrown\SmartThings\Serializer\ButtonForTvSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForLightSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemReferToSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemSerializer;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraImageTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemActionsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemProgressBarsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlColorTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsBarItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsStateItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardColorsTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusStateBoardItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvChannelTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeTransformer;
use ChristianBrown\SmartThings\Transformer\ButtonForTvTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForLightTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class BasicPlusShapeRegistrar implements ServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_SERIALIZER, BasicPlusItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_TRANSFORMER, BasicPlusItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_PANEL_FOR_DEVICE_CONFIG_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER, BasicPlusCameraImageSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER, BasicPlusCameraImageTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER, BasicPlusCameraOverlayIconsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER, BasicPlusCameraOverlayIconsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_SERIALIZER, BasicPlusCameraSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_TRANSFORMER, BasicPlusCameraTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_IMAGE_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_CAMERA_OVERLAY_ICONS_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER, BasicPlusTvVolumeCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER, BasicPlusTvVolumeCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER, BasicPlusTvVolumeSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER, BasicPlusTvVolumeTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER, ButtonForTvSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER, ButtonForTvTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER, BasicPlusTvChannelSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER, BasicPlusTvChannelTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER, BasicPlusTvDirectionalPadCommandSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER, BasicPlusTvDirectionalPadCommandTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER, BasicPlusTvDirectionalPadSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER, BasicPlusTvDirectionalPadTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_COMMAND_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_SERIALIZER, BasicPlusTvSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_TRANSFORMER, BasicPlusTvTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_VOLUME_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BUTTON_FOR_TV_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_CHANNEL_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_TV_DIRECTIONAL_PAD_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER, SliderForLightSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER, SliderForLightTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER, BasicPlusLightColorControlColorSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER, BasicPlusLightColorControlColorTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER, BasicPlusLightColorControlSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER, BasicPlusLightColorControlTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_COLOR_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_SERIALIZER, BasicPlusLightSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_TRANSFORMER, BasicPlusLightTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_SLIDER_FOR_LIGHT_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_LIGHT_COLOR_CONTROL_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_SERIALIZER, BasicPlusItemActionsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_ACTIONS_ITEM_TRANSFORMER, BasicPlusItemActionsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER, VisibleConditionForColorItemReferToSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER, VisibleConditionForColorItemReferToTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER, VisibleConditionForColorItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER, VisibleConditionForColorItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_REFER_TO_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER, BasicPlusStateBoardColorsSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER, BasicPlusStateBoardColorsTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_FOR_COLOR_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_SERIALIZER, BasicPlusStateBoardItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_ITEM_TRANSFORMER, BasicPlusStateBoardItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_STATE_BOARD_COLORS_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER, BasicPlusProgressBarsStateItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER, BasicPlusProgressBarsStateItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_ALTERNATIVE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_DEVICE_CONFIG_ENTRY_FOR_DASHBOARD_STATE_FORMAT_INFO_ITEM_TRANSFORMER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER, BasicPlusProgressBarsBarItemSerializer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER, BasicPlusProgressBarsBarItemTransformer::class);
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_SERIALIZER, BasicPlusItemProgressBarsItemSerializer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_SERIALIZER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_SERIALIZER),
                ]
            );
        $container->register(SmartThingsInterface::SERVICE_BASIC_PLUS_ITEM_PROGRESS_BARS_ITEM_TRANSFORMER, BasicPlusItemProgressBarsItemTransformer::class)
            ->setArguments(
                [
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_STATE_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_BASIC_PLUS_PROGRESS_BARS_BAR_ITEM_TRANSFORMER),
                    new Reference(SmartThingsInterface::SERVICE_VISIBLE_CONDITION_TRANSFORMER),
                ]
            );
    }
}
