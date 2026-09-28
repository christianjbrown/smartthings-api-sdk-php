<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AppOauthDefinitionInterface;
use ChristianBrown\SmartThings\Model\AppUiSettingsInterface;
use ChristianBrown\SmartThings\Model\CreateAppRequestInterface;
use ChristianBrown\SmartThings\Model\CreateOrUpdateLambdaSmartAppRequestInterface;
use ChristianBrown\SmartThings\Model\CreateOrUpdateWebhookSmartAppRequestInterface;
use ChristianBrown\SmartThings\Model\IconImageInterface;

use function array_filter;

final class CreateAppRequestSerializer implements CreateAppRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CreateAppRequestInterface $request): array
    {
        return self::filter([
            self::KEY_APP_NAME => $request->getAppName(),
            self::KEY_DISPLAY_NAME => $request->getDisplayName(),
            self::KEY_DESCRIPTION => $request->getDescription(),
            self::KEY_SINGLE_INSTANCE => $request->getSingleInstance(),
            self::KEY_ICON_IMAGE => self::serializeOptionalIconImage($request->getIconImage()),
            self::KEY_APP_TYPE => $request->getAppType(),
            self::KEY_PRINCIPAL_TYPE => $request->getPrincipalType(),
            self::KEY_CLASSIFICATIONS => $request->getClassifications(),
            self::KEY_LAMBDA_SMART_APP => self::serializeOptionalCreateOrUpdateLambdaSmartAppRequest($request->getLambdaSmartApp()),
            self::KEY_WEBHOOK_SMART_APP => self::serializeOptionalCreateOrUpdateWebhookSmartAppRequest($request->getWebhookSmartApp()),
            self::KEY_OAUTH => self::serializeOptionalAppOauthDefinition($request->getOauth()),
            self::KEY_UI => self::serializeOptionalAppUiSettings($request->getUi()),
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
     * @return mixed[]
     */
    private static function serializeAppOauthDefinition(AppOauthDefinitionInterface $value): array
    {
        return self::filter([
            self::KEY_CLIENT_NAME => $value->getClientName(),
            self::KEY_SCOPE => $value->getScope(),
            self::KEY_REDIRECT_URIS => $value->getRedirectUris(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeAppUiSettings(AppUiSettingsInterface $value): array
    {
        return self::filter([
            self::KEY_PLUGIN_ID => $value->getPluginId(),
            self::KEY_PLUGIN_URI => $value->getPluginUri(),
            self::KEY_DASHBOARD_CARDS_ENABLED => $value->getDashboardCardsEnabled(),
            self::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => $value->getPreInstallDashboardCardsEnabled(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCreateOrUpdateLambdaSmartAppRequest(CreateOrUpdateLambdaSmartAppRequestInterface $value): array
    {
        return self::filter([
            self::KEY_FUNCTIONS => $value->getFunctions(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeCreateOrUpdateWebhookSmartAppRequest(CreateOrUpdateWebhookSmartAppRequestInterface $value): array
    {
        return self::filter([
            self::KEY_TARGET_URL => $value->getTargetUrl(),
        ]);
    }

    /**
     * @return mixed[]
     */
    private static function serializeIconImage(IconImageInterface $value): array
    {
        return self::filter([
            self::KEY_URL => $value->getUrl(),
        ]);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAppOauthDefinition(?AppOauthDefinitionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAppOauthDefinition($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalAppUiSettings(?AppUiSettingsInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeAppUiSettings($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCreateOrUpdateLambdaSmartAppRequest(?CreateOrUpdateLambdaSmartAppRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCreateOrUpdateLambdaSmartAppRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalCreateOrUpdateWebhookSmartAppRequest(?CreateOrUpdateWebhookSmartAppRequestInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeCreateOrUpdateWebhookSmartAppRequest($value);
    }

    /**
     * @return null|mixed[]
     */
    private static function serializeOptionalIconImage(?IconImageInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return self::serializeIconImage($value);
    }
}
