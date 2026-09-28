<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;

interface SmartThingsAutomationInterface
{
    public function getRuleApi(): RuleApiInterface;

    public function getSceneApi(): SceneApiInterface;

    public function getScheduleApi(): ScheduleApiInterface;

    public function getSubscriptionApi(): SubscriptionApiInterface;
}
