<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\Action;
use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\CommandActionInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;
use ChristianBrown\SmartThings\Model\IfActionInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;
use ChristianBrown\SmartThings\Model\LocationActionInterface;
use ChristianBrown\SmartThings\Model\SceneActionInterface;
use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Model\ToggleActionInterface;

use function is_array;

/**
 * Builds ActionInterface from its decoded JSON.
 */
final class ActionNodeTransformer implements ActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): ActionInterface
    {
        $model = new Action();

        self::applyIf($model, $data, $registry);
        self::applySleep($model, $data, $registry);
        self::applyCommand($model, $data, $registry);
        self::applyScene($model, $data, $registry);
        self::applyEvery($model, $data, $registry);
        self::applyLocation($model, $data, $registry);
        self::applyLimit($model, $data, $registry);
        self::applyToggle($model, $data, $registry);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommand(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return;
        }
        $model->setCommand($registry->get(CommandActionInterface::class)->transform($data[self::KEY_COMMAND], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEvery(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_EVERY])) {
            return;
        }
        if (!is_array($data[self::KEY_EVERY])) {
            return;
        }
        $model->setEvery($registry->get(EveryActionInterface::class)->transform($data[self::KEY_EVERY], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIf(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_IF])) {
            return;
        }
        if (!is_array($data[self::KEY_IF])) {
            return;
        }
        $model->setIf($registry->get(IfActionInterface::class)->transform($data[self::KEY_IF], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLimit(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_LIMIT])) {
            return;
        }
        if (!is_array($data[self::KEY_LIMIT])) {
            return;
        }
        $model->setLimit($registry->get(LimitActionInterface::class)->transform($data[self::KEY_LIMIT], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocation(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCATION])) {
            return;
        }
        $model->setLocation($registry->get(LocationActionInterface::class)->transform($data[self::KEY_LOCATION], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyScene(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SCENE])) {
            return;
        }
        if (!is_array($data[self::KEY_SCENE])) {
            return;
        }
        $model->setScene($registry->get(SceneActionInterface::class)->transform($data[self::KEY_SCENE], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySleep(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_SLEEP])) {
            return;
        }
        if (!is_array($data[self::KEY_SLEEP])) {
            return;
        }
        $model->setSleep($registry->get(SleepActionInterface::class)->transform($data[self::KEY_SLEEP], $registry));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyToggle(Action $model, array $data, NodeTransformerRegistryInterface $registry): void
    {
        if (!isset($data[self::KEY_TOGGLE])) {
            return;
        }
        if (!is_array($data[self::KEY_TOGGLE])) {
            return;
        }
        $model->setToggle($registry->get(ToggleActionInterface::class)->transform($data[self::KEY_TOGGLE], $registry));
    }
}
