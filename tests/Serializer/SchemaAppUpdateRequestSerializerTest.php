<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppUpdateRequest;
use ChristianBrown\SmartThings\Model\ViperAppLinks;
use ChristianBrown\SmartThings\Serializer\SchemaAppUpdateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaAppUpdateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppUpdateRequest::class)]
#[CoversClass(ViperAppLinks::class)]
#[CoversClass(SchemaAppUpdateRequestSerializer::class)]
final class SchemaAppUpdateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new SchemaAppUpdateRequest();

        $serializer = new SchemaAppUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new SchemaAppUpdateRequest())
            ->setAppName('test-app-name')
            ->setPartnerName('test-partner-name')
            ->setOAuthAuthorizationUrl('test-o-auth-authorization-url')
            ->setLambdaArn('test-lambda-arn')
            ->setLambdaArnEU('test-lambda-arn-eu')
            ->setLambdaArnAP('test-lambda-arn-ap')
            ->setLambdaArnCN('test-lambda-arn-cn')
            ->setIcon('test-icon')
            ->setIcon2x('test-icon2x')
            ->setIcon3x('test-icon3x')
            ->setEndpointAppId('test-endpoint-app-id')
            ->setOAuthClientId('test-o-auth-client-id')
            ->setOAuthClientSecret('test-o-auth-client-secret')
            ->setOAuthTokenUrl('test-o-auth-token-url')
            ->setOrganizationId('test-organization-id')
            ->setOAuthScope('test-o-auth-scope')
            ->setUserId('test-user-id')
            ->setHostingType('test-hosting-type')
            ->setSchemaType('test-schema-type')
            ->setWebhookUrl('test-webhook-url')
            ->setCertificationStatus('test-certification-status')
            ->setUserEmail('test-user-email')
            ->setViperAppLinks((new ViperAppLinks())
                ->setAndroid('test-android')
                ->setIos('test-ios')
                ->setIsLinkingEnabled(true));

        $serializer = new SchemaAppUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppUpdateRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                SchemaAppUpdateRequestSerializerInterface::KEY_PARTNER_NAME => 'test-partner-name',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN => 'test-lambda-arn',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_EU => 'test-lambda-arn-eu',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_AP => 'test-lambda-arn-ap',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_CN => 'test-lambda-arn-cn',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON => 'test-icon',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON2X => 'test-icon2x',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON3X => 'test-icon3x',
                SchemaAppUpdateRequestSerializerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_ORGANIZATION_ID => 'test-organization-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_SCOPE => 'test-o-auth-scope',
                SchemaAppUpdateRequestSerializerInterface::KEY_USER_ID => 'test-user-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_HOSTING_TYPE => 'test-hosting-type',
                SchemaAppUpdateRequestSerializerInterface::KEY_SCHEMA_TYPE => 'test-schema-type',
                SchemaAppUpdateRequestSerializerInterface::KEY_WEBHOOK_URL => 'test-webhook-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_CERTIFICATION_STATUS => 'test-certification-status',
                SchemaAppUpdateRequestSerializerInterface::KEY_USER_EMAIL => 'test-user-email',
                SchemaAppUpdateRequestSerializerInterface::KEY_VIPER_APP_LINKS => [
                    SchemaAppUpdateRequestSerializerInterface::KEY_ANDROID => 'test-android',
                    SchemaAppUpdateRequestSerializerInterface::KEY_IOS => 'test-ios',
                    SchemaAppUpdateRequestSerializerInterface::KEY_IS_LINKING_ENABLED => true,
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new SchemaAppUpdateRequest())
            ->setAppName('test-app-name')
            ->setPartnerName('test-partner-name')
            ->setOAuthAuthorizationUrl('test-o-auth-authorization-url')
            ->setLambdaArn('test-lambda-arn')
            ->setLambdaArnEU('test-lambda-arn-eu')
            ->setLambdaArnAP('test-lambda-arn-ap')
            ->setLambdaArnCN('test-lambda-arn-cn')
            ->setIcon('test-icon')
            ->setIcon2x('test-icon2x')
            ->setIcon3x('test-icon3x')
            ->setEndpointAppId('test-endpoint-app-id')
            ->setOAuthClientId('test-o-auth-client-id')
            ->setOAuthClientSecret('test-o-auth-client-secret')
            ->setOAuthTokenUrl('test-o-auth-token-url')
            ->setOrganizationId('test-organization-id')
            ->setOAuthScope('test-o-auth-scope')
            ->setUserId('test-user-id')
            ->setHostingType('test-hosting-type')
            ->setSchemaType('test-schema-type')
            ->setWebhookUrl('test-webhook-url')
            ->setCertificationStatus('test-certification-status')
            ->setUserEmail('test-user-email')
            ->setViperAppLinks(new ViperAppLinks());

        $serializer = new SchemaAppUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppUpdateRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                SchemaAppUpdateRequestSerializerInterface::KEY_PARTNER_NAME => 'test-partner-name',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN => 'test-lambda-arn',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_EU => 'test-lambda-arn-eu',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_AP => 'test-lambda-arn-ap',
                SchemaAppUpdateRequestSerializerInterface::KEY_LAMBDA_ARN_CN => 'test-lambda-arn-cn',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON => 'test-icon',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON2X => 'test-icon2x',
                SchemaAppUpdateRequestSerializerInterface::KEY_ICON3X => 'test-icon3x',
                SchemaAppUpdateRequestSerializerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_ORGANIZATION_ID => 'test-organization-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_O_AUTH_SCOPE => 'test-o-auth-scope',
                SchemaAppUpdateRequestSerializerInterface::KEY_USER_ID => 'test-user-id',
                SchemaAppUpdateRequestSerializerInterface::KEY_HOSTING_TYPE => 'test-hosting-type',
                SchemaAppUpdateRequestSerializerInterface::KEY_SCHEMA_TYPE => 'test-schema-type',
                SchemaAppUpdateRequestSerializerInterface::KEY_WEBHOOK_URL => 'test-webhook-url',
                SchemaAppUpdateRequestSerializerInterface::KEY_CERTIFICATION_STATUS => 'test-certification-status',
                SchemaAppUpdateRequestSerializerInterface::KEY_USER_EMAIL => 'test-user-email',
                SchemaAppUpdateRequestSerializerInterface::KEY_VIPER_APP_LINKS => [],
            ],
            $actual
        );
    }
}
