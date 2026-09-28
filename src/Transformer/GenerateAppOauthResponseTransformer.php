<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\GenerateAppOauthResponse;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponseInterface;

use function is_array;
use function is_string;

final class GenerateAppOauthResponseTransformer implements GenerateAppOauthResponseTransformerInterface
{
    private AppOauthTransformerInterface $appOauthTransformer;

    public function __construct(AppOauthTransformerInterface $appOauthTransformer)
    {
        $this->appOauthTransformer = $appOauthTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): GenerateAppOauthResponseInterface
    {
        $model = new GenerateAppOauthResponse();

        $this->applyOauthClientDetails($model, $data);
        self::applyOauthClientId($model, $data);
        self::applyOauthClientSecret($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOauthClientDetails(GenerateAppOauthResponse $model, array $data): void
    {
        if (!isset($data[self::KEY_OAUTH_CLIENT_DETAILS])) {
            return;
        }
        if (!is_array($data[self::KEY_OAUTH_CLIENT_DETAILS])) {
            return;
        }
        $model->setOauthClientDetails($this->appOauthTransformer->transform($data[self::KEY_OAUTH_CLIENT_DETAILS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOauthClientId(GenerateAppOauthResponse $model, array $data): void
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
    private static function applyOauthClientSecret(GenerateAppOauthResponse $model, array $data): void
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
