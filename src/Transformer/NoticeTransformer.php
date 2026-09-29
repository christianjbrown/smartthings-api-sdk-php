<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\Notice;
use ChristianBrown\SmartThings\Model\NoticeInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class NoticeTransformer implements NoticeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NoticeInterface
    {
        $model = new Notice();

        self::applyCode($model, $data);
        self::applyBadgeUrl($model, $data);
        self::applyMessage($model, $data);
        self::applyActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActions(Notice $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions(array_values(array_filter($data[self::KEY_ACTIONS], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBadgeUrl(Notice $model, array $data): void
    {
        if (empty($data[self::KEY_BADGE_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_BADGE_URL])) {
            return;
        }
        $model->setBadgeUrl($data[self::KEY_BADGE_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCode(Notice $model, array $data): void
    {
        if (empty($data[self::KEY_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_CODE])) {
            return;
        }
        $model->setCode($data[self::KEY_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMessage(Notice $model, array $data): void
    {
        if (empty($data[self::KEY_MESSAGE])) {
            return;
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            return;
        }
        $model->setMessage($data[self::KEY_MESSAGE]);
    }
}
