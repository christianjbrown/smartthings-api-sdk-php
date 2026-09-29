<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Subscription;
use ChristianBrown\SmartThings\Model\SubscriptionDetailsInterface;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;

use function array_flip;
use function array_intersect_key;
use function is_string;
use function sprintf;

final class SubscriptionTransformer implements SubscriptionTransformerInterface
{
    private SubscriptionDetailsTransformerInterface $subscriptionDetailsTransformer;

    public function __construct(SubscriptionDetailsTransformerInterface $subscriptionDetailsTransformer)
    {
        $this->subscriptionDetailsTransformer = $subscriptionDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $subscription = new Subscription($data[self::KEY_ID]);

        self::applyInstalledAppId($subscription, $data);
        self::applySourceType($subscription, $data);

        $this->applyDetails($subscription, $data);

        return $subscription;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(Subscription $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->subscriptionDetailsTransformer->transform($data);
        self::copyDevice($model, $details);
        self::copyCapability($model, $details);
        self::copyMode($model, $details);
        self::copyDeviceLifecycle($model, $details);
        self::copyDeviceHealth($model, $details);
        self::copySecurityArmState($model, $details);
        self::copyHubHealth($model, $details);
        self::copySceneLifecycle($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppId(Subscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        $subscription->setInstalledAppId($data[self::KEY_INSTALLED_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySourceType(Subscription $subscription, array $data): void
    {
        if (empty($data[self::KEY_SOURCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SOURCE_TYPE])) {
            return;
        }
        $subscription->setSourceType($data[self::KEY_SOURCE_TYPE]);
    }

    private static function copyCapability(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setCapability($details->getCapability());
    }

    private static function copyDevice(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setDevice($details->getDevice());
    }

    private static function copyDeviceHealth(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setDeviceHealth($details->getDeviceHealth());
    }

    private static function copyDeviceLifecycle(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setDeviceLifecycle($details->getDeviceLifecycle());
    }

    private static function copyHubHealth(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setHubHealth($details->getHubHealth());
    }

    private static function copyMode(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setMode($details->getMode());
    }

    private static function copySceneLifecycle(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setSceneLifecycle($details->getSceneLifecycle());
    }

    private static function copySecurityArmState(Subscription $model, SubscriptionDetailsInterface $details): void
    {
        $model->setSecurityArmState($details->getSecurityArmState());
    }
}
