<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaApp;
use ChristianBrown\SmartThings\Model\SchemaAppDetailsInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;

use function array_flip;
use function array_intersect_key;
use function is_string;
use function sprintf;

final class SchemaAppTransformer implements SchemaAppTransformerInterface
{
    private SchemaAppDetailsTransformerInterface $schemaAppDetailsTransformer;

    public function __construct(SchemaAppDetailsTransformerInterface $schemaAppDetailsTransformer)
    {
        $this->schemaAppDetailsTransformer = $schemaAppDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInterface
    {
        if (empty($data[self::KEY_ENDPOINT_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ENDPOINT_APP_ID));
        }
        if (!is_string($data[self::KEY_ENDPOINT_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ENDPOINT_APP_ID));
        }
        $app = new SchemaApp($data[self::KEY_ENDPOINT_APP_ID]);

        self::applyAppName($app, $data);
        self::applyCertificationStatus($app, $data);
        self::applyPartnerName($app, $data);
        self::applyStClientId($app, $data);

        self::applyOAuthAuthorizationUrl($app, $data);
        self::applyLambdaArn($app, $data);
        self::applyLambdaArnEU($app, $data);
        self::applyLambdaArnAP($app, $data);
        self::applyLambdaArnCN($app, $data);
        self::applyIcon($app, $data);
        self::applyIcon2x($app, $data);
        self::applyIcon3x($app, $data);
        self::applyOAuthClientId($app, $data);
        self::applyOAuthClientSecret($app, $data);
        self::applyOAuthTokenUrl($app, $data);
        self::applyOrganizationId($app, $data);
        self::applyOAuthScope($app, $data);
        self::applyUserId($app, $data);
        self::applyHostingType($app, $data);
        self::applySchemaType($app, $data);
        self::applyWebhookUrl($app, $data);
        self::applyUserEmail($app, $data);

        $this->applyDetails($app, $data);

        return $app;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_APP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_NAME])) {
            return;
        }
        $app->setAppName($data[self::KEY_APP_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCertificationStatus(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_CERTIFICATION_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_CERTIFICATION_STATUS])) {
            return;
        }
        $app->setCertificationStatus($data[self::KEY_CERTIFICATION_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(SchemaApp $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->schemaAppDetailsTransformer->transform($data);
        self::copyViperAppLinks($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHostingType(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_HOSTING_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_HOSTING_TYPE])) {
            return;
        }
        $model->setHostingType($data[self::KEY_HOSTING_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIcon(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_ICON])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON])) {
            return;
        }
        $model->setIcon($data[self::KEY_ICON]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIcon2x(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_ICON2X])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON2X])) {
            return;
        }
        $model->setIcon2x($data[self::KEY_ICON2X]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIcon3x(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_ICON3X])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON3X])) {
            return;
        }
        $model->setIcon3x($data[self::KEY_ICON3X]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLambdaArn(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_LAMBDA_ARN])) {
            return;
        }
        if (!is_string($data[self::KEY_LAMBDA_ARN])) {
            return;
        }
        $model->setLambdaArn($data[self::KEY_LAMBDA_ARN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLambdaArnAP(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_LAMBDA_ARN_AP])) {
            return;
        }
        if (!is_string($data[self::KEY_LAMBDA_ARN_AP])) {
            return;
        }
        $model->setLambdaArnAP($data[self::KEY_LAMBDA_ARN_AP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLambdaArnCN(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_LAMBDA_ARN_CN])) {
            return;
        }
        if (!is_string($data[self::KEY_LAMBDA_ARN_CN])) {
            return;
        }
        $model->setLambdaArnCN($data[self::KEY_LAMBDA_ARN_CN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLambdaArnEU(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_LAMBDA_ARN_EU])) {
            return;
        }
        if (!is_string($data[self::KEY_LAMBDA_ARN_EU])) {
            return;
        }
        $model->setLambdaArnEU($data[self::KEY_LAMBDA_ARN_EU]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthAuthorizationUrl(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_AUTHORIZATION_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_AUTHORIZATION_URL])) {
            return;
        }
        $model->setOAuthAuthorizationUrl($data[self::KEY_O_AUTH_AUTHORIZATION_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthClientId(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_CLIENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_CLIENT_ID])) {
            return;
        }
        $model->setOAuthClientId($data[self::KEY_O_AUTH_CLIENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthClientSecret(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_CLIENT_SECRET])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_CLIENT_SECRET])) {
            return;
        }
        $model->setOAuthClientSecret($data[self::KEY_O_AUTH_CLIENT_SECRET]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthScope(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_SCOPE])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_SCOPE])) {
            return;
        }
        $model->setOAuthScope($data[self::KEY_O_AUTH_SCOPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthTokenUrl(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_TOKEN_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_TOKEN_URL])) {
            return;
        }
        $model->setOAuthTokenUrl($data[self::KEY_O_AUTH_TOKEN_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOrganizationId(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_ORGANIZATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ORGANIZATION_ID])) {
            return;
        }
        $model->setOrganizationId($data[self::KEY_ORGANIZATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPartnerName(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        $app->setPartnerName($data[self::KEY_PARTNER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySchemaType(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_SCHEMA_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_SCHEMA_TYPE])) {
            return;
        }
        $model->setSchemaType($data[self::KEY_SCHEMA_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStClientId(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        $app->setStClientId($data[self::KEY_ST_CLIENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUserEmail(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_USER_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_USER_EMAIL])) {
            return;
        }
        $model->setUserEmail($data[self::KEY_USER_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUserId(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_USER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_USER_ID])) {
            return;
        }
        $model->setUserId($data[self::KEY_USER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWebhookUrl(SchemaApp $model, array $data): void
    {
        if (empty($data[self::KEY_WEBHOOK_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_WEBHOOK_URL])) {
            return;
        }
        $model->setWebhookUrl($data[self::KEY_WEBHOOK_URL]);
    }

    private static function copyViperAppLinks(SchemaApp $model, SchemaAppDetailsInterface $details): void
    {
        $model->setViperAppLinks($details->getViperAppLinks());
    }
}
