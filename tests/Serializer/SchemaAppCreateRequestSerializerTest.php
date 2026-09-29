<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SchemaAppCreateRequest;
use ChristianBrown\SmartThings\Model\ViperAppLinks;
use ChristianBrown\SmartThings\Serializer\SchemaAppCreateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SchemaAppCreateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppCreateRequest::class)]
#[CoversClass(ViperAppLinks::class)]
#[CoversClass(SchemaAppCreateRequestSerializer::class)]
final class SchemaAppCreateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new SchemaAppCreateRequest('test-app-name', 'test-partner-name', 'test-o-auth-authorization-url', 'test-o-auth-client-id', 'test-o-auth-client-secret', 'test-o-auth-token-url', 'test-hosting-type', 'test-user-email');

        $serializer = new SchemaAppCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppCreateRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                SchemaAppCreateRequestSerializerInterface::KEY_PARTNER_NAME => 'test-partner-name',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url',
                SchemaAppCreateRequestSerializerInterface::KEY_HOSTING_TYPE => 'test-hosting-type',
                SchemaAppCreateRequestSerializerInterface::KEY_USER_EMAIL => 'test-user-email',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new SchemaAppCreateRequest('test-app-name', 'test-partner-name', 'test-o-auth-authorization-url', 'test-o-auth-client-id', 'test-o-auth-client-secret', 'test-o-auth-token-url', 'test-hosting-type', 'test-user-email'))
            ->setLambdaArn('test-lambda-arn')
            ->setLambdaArnEU('test-lambda-arn-eu')
            ->setLambdaArnAP('test-lambda-arn-ap')
            ->setLambdaArnCN('test-lambda-arn-cn')
            ->setIcon('test-icon')
            ->setIcon2x('test-icon2x')
            ->setIcon3x('test-icon3x')
            ->setEndpointAppId('test-endpoint-app-id')
            ->setOAuthScope('test-o-auth-scope')
            ->setUserId('test-user-id')
            ->setSchemaType('test-schema-type')
            ->setWebhookUrl('test-webhook-url')
            ->setCertificationStatus('test-certification-status')
            ->setViperAppLinks((new ViperAppLinks())
                ->setAndroid('test-android')
                ->setIos('test-ios')
                ->setIsLinkingEnabled(true));

        $serializer = new SchemaAppCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppCreateRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                SchemaAppCreateRequestSerializerInterface::KEY_PARTNER_NAME => 'test-partner-name',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN => 'test-lambda-arn',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_EU => 'test-lambda-arn-eu',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_AP => 'test-lambda-arn-ap',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_CN => 'test-lambda-arn-cn',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON => 'test-icon',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON2X => 'test-icon2x',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON3X => 'test-icon3x',
                SchemaAppCreateRequestSerializerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_SCOPE => 'test-o-auth-scope',
                SchemaAppCreateRequestSerializerInterface::KEY_USER_ID => 'test-user-id',
                SchemaAppCreateRequestSerializerInterface::KEY_HOSTING_TYPE => 'test-hosting-type',
                SchemaAppCreateRequestSerializerInterface::KEY_SCHEMA_TYPE => 'test-schema-type',
                SchemaAppCreateRequestSerializerInterface::KEY_WEBHOOK_URL => 'test-webhook-url',
                SchemaAppCreateRequestSerializerInterface::KEY_CERTIFICATION_STATUS => 'test-certification-status',
                SchemaAppCreateRequestSerializerInterface::KEY_USER_EMAIL => 'test-user-email',
                SchemaAppCreateRequestSerializerInterface::KEY_VIPER_APP_LINKS => [
                    SchemaAppCreateRequestSerializerInterface::KEY_ANDROID => 'test-android',
                    SchemaAppCreateRequestSerializerInterface::KEY_IOS => 'test-ios',
                    SchemaAppCreateRequestSerializerInterface::KEY_IS_LINKING_ENABLED => true,
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new SchemaAppCreateRequest('test-app-name', 'test-partner-name', 'test-o-auth-authorization-url', 'test-o-auth-client-id', 'test-o-auth-client-secret', 'test-o-auth-token-url', 'test-hosting-type', 'test-user-email'))
            ->setLambdaArn('test-lambda-arn')
            ->setLambdaArnEU('test-lambda-arn-eu')
            ->setLambdaArnAP('test-lambda-arn-ap')
            ->setLambdaArnCN('test-lambda-arn-cn')
            ->setIcon('test-icon')
            ->setIcon2x('test-icon2x')
            ->setIcon3x('test-icon3x')
            ->setEndpointAppId('test-endpoint-app-id')
            ->setOAuthScope('test-o-auth-scope')
            ->setUserId('test-user-id')
            ->setSchemaType('test-schema-type')
            ->setWebhookUrl('test-webhook-url')
            ->setCertificationStatus('test-certification-status')
            ->setViperAppLinks(new ViperAppLinks());

        $serializer = new SchemaAppCreateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                SchemaAppCreateRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                SchemaAppCreateRequestSerializerInterface::KEY_PARTNER_NAME => 'test-partner-name',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN => 'test-lambda-arn',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_EU => 'test-lambda-arn-eu',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_AP => 'test-lambda-arn-ap',
                SchemaAppCreateRequestSerializerInterface::KEY_LAMBDA_ARN_CN => 'test-lambda-arn-cn',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON => 'test-icon',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON2X => 'test-icon2x',
                SchemaAppCreateRequestSerializerInterface::KEY_ICON3X => 'test-icon3x',
                SchemaAppCreateRequestSerializerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url',
                SchemaAppCreateRequestSerializerInterface::KEY_O_AUTH_SCOPE => 'test-o-auth-scope',
                SchemaAppCreateRequestSerializerInterface::KEY_USER_ID => 'test-user-id',
                SchemaAppCreateRequestSerializerInterface::KEY_HOSTING_TYPE => 'test-hosting-type',
                SchemaAppCreateRequestSerializerInterface::KEY_SCHEMA_TYPE => 'test-schema-type',
                SchemaAppCreateRequestSerializerInterface::KEY_WEBHOOK_URL => 'test-webhook-url',
                SchemaAppCreateRequestSerializerInterface::KEY_CERTIFICATION_STATUS => 'test-certification-status',
                SchemaAppCreateRequestSerializerInterface::KEY_USER_EMAIL => 'test-user-email',
                SchemaAppCreateRequestSerializerInterface::KEY_VIPER_APP_LINKS => [],
            ],
            $actual
        );
    }
}
