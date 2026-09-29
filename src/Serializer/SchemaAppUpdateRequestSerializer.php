<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppUpdateRequestInterface;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;

use function array_filter;

final class SchemaAppUpdateRequestSerializer implements SchemaAppUpdateRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SchemaAppUpdateRequestInterface $request): array
    {
        return self::filter([
            self::KEY_APP_NAME => $request->getAppName(),
            self::KEY_PARTNER_NAME => $request->getPartnerName(),
            self::KEY_O_AUTH_AUTHORIZATION_URL => $request->getOAuthAuthorizationUrl(),
            self::KEY_LAMBDA_ARN => $request->getLambdaArn(),
            self::KEY_LAMBDA_ARN_EU => $request->getLambdaArnEU(),
            self::KEY_LAMBDA_ARN_AP => $request->getLambdaArnAP(),
            self::KEY_LAMBDA_ARN_CN => $request->getLambdaArnCN(),
            self::KEY_ICON => $request->getIcon(),
            self::KEY_ICON2X => $request->getIcon2x(),
            self::KEY_ICON3X => $request->getIcon3x(),
            self::KEY_ENDPOINT_APP_ID => $request->getEndpointAppId(),
            self::KEY_O_AUTH_CLIENT_ID => $request->getOAuthClientId(),
            self::KEY_O_AUTH_CLIENT_SECRET => $request->getOAuthClientSecret(),
            self::KEY_O_AUTH_TOKEN_URL => $request->getOAuthTokenUrl(),
            self::KEY_ORGANIZATION_ID => $request->getOrganizationId(),
            self::KEY_O_AUTH_SCOPE => $request->getOAuthScope(),
            self::KEY_USER_ID => $request->getUserId(),
            self::KEY_HOSTING_TYPE => $request->getHostingType(),
            self::KEY_SCHEMA_TYPE => $request->getSchemaType(),
            self::KEY_WEBHOOK_URL => $request->getWebhookUrl(),
            self::KEY_CERTIFICATION_STATUS => $request->getCertificationStatus(),
            self::KEY_USER_EMAIL => $request->getUserEmail(),
            self::KEY_VIPER_APP_LINKS => self::serializeOptionalViperAppLinks($request->getViperAppLinks()),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalViperAppLinks(?ViperAppLinksInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeViperAppLinks($value);
    }

    /**
     * @return mixed[]
     */
    private static function serializeViperAppLinks(ViperAppLinksInterface $value): array
    {
        return self::filter([
            self::KEY_ANDROID => $value->getAndroid(),
            self::KEY_IOS => $value->getIos(),
            self::KEY_IS_LINKING_ENABLED => $value->getIsLinkingEnabled(),
        ]);
    }
}
