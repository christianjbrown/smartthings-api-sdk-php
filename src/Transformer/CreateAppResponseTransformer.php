<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateAppResponse;
use ChristianBrown\SmartThings\Model\CreateAppResponseInterface;

use function is_array;
use function is_string;

final class CreateAppResponseTransformer implements CreateAppResponseTransformerInterface
{
    private AppTransformerInterface $appTransformer;

    public function __construct(AppTransformerInterface $appTransformer)
    {
        $this->appTransformer = $appTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateAppResponseInterface
    {
        $model = new CreateAppResponse();

        $this->applyApp($model, $data);
        self::applyOauthClientId($model, $data);
        self::applyOauthClientSecret($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyApp(CreateAppResponse $model, array $data): void
    {
        if (!isset($data[self::KEY_APP])) {
            return;
        }
        if (!is_array($data[self::KEY_APP])) {
            return;
        }
        $model->setApp($this->appTransformer->transform($data[self::KEY_APP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOauthClientId(CreateAppResponse $model, array $data): void
    {
        if (empty($data[self::KEY_OAUTH_CLIENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_OAUTH_CLIENT_ID])) {
            return;
        }
        $model->setOauthClientId($data[self::KEY_OAUTH_CLIENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOauthClientSecret(CreateAppResponse $model, array $data): void
    {
        if (empty($data[self::KEY_OAUTH_CLIENT_SECRET])) {
            return;
        }
        if (!is_string($data[self::KEY_OAUTH_CLIENT_SECRET])) {
            return;
        }
        $model->setOauthClientSecret($data[self::KEY_OAUTH_CLIENT_SECRET]);
    }
}
