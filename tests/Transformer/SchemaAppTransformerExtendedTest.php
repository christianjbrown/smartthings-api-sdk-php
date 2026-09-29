<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaApp;
use ChristianBrown\SmartThings\Model\SchemaAppDetailsInterface;
use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaApp::class)]
#[CoversClass(SchemaAppTransformer::class)]
final class SchemaAppTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SchemaAppTransformer(self::createStub(SchemaAppDetailsTransformerInterface::class));

        $actual = $transformer->transform([SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'oAuthAuthorizationUrlAbsent' => [[], 'getOAuthAuthorizationUrl', null];
        yield 'oAuthAuthorizationUrlWrongType' => [[SchemaAppTransformerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 42], 'getOAuthAuthorizationUrl', null];
        yield 'oAuthAuthorizationUrlValid' => [[SchemaAppTransformerInterface::KEY_O_AUTH_AUTHORIZATION_URL => 'test-o-auth-authorization-url'], 'getOAuthAuthorizationUrl', 'test-o-auth-authorization-url'];
        yield 'lambdaArnAbsent' => [[], 'getLambdaArn', null];
        yield 'lambdaArnWrongType' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN => 42], 'getLambdaArn', null];
        yield 'lambdaArnValid' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN => 'test-lambda-arn'], 'getLambdaArn', 'test-lambda-arn'];
        yield 'lambdaArnEUAbsent' => [[], 'getLambdaArnEU', null];
        yield 'lambdaArnEUWrongType' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_EU => 42], 'getLambdaArnEU', null];
        yield 'lambdaArnEUValid' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_EU => 'test-lambda-arn-eu'], 'getLambdaArnEU', 'test-lambda-arn-eu'];
        yield 'lambdaArnAPAbsent' => [[], 'getLambdaArnAP', null];
        yield 'lambdaArnAPWrongType' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_AP => 42], 'getLambdaArnAP', null];
        yield 'lambdaArnAPValid' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_AP => 'test-lambda-arn-ap'], 'getLambdaArnAP', 'test-lambda-arn-ap'];
        yield 'lambdaArnCNAbsent' => [[], 'getLambdaArnCN', null];
        yield 'lambdaArnCNWrongType' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_CN => 42], 'getLambdaArnCN', null];
        yield 'lambdaArnCNValid' => [[SchemaAppTransformerInterface::KEY_LAMBDA_ARN_CN => 'test-lambda-arn-cn'], 'getLambdaArnCN', 'test-lambda-arn-cn'];
        yield 'iconAbsent' => [[], 'getIcon', null];
        yield 'iconWrongType' => [[SchemaAppTransformerInterface::KEY_ICON => 42], 'getIcon', null];
        yield 'iconValid' => [[SchemaAppTransformerInterface::KEY_ICON => 'test-icon'], 'getIcon', 'test-icon'];
        yield 'icon2xAbsent' => [[], 'getIcon2x', null];
        yield 'icon2xWrongType' => [[SchemaAppTransformerInterface::KEY_ICON2X => 42], 'getIcon2x', null];
        yield 'icon2xValid' => [[SchemaAppTransformerInterface::KEY_ICON2X => 'test-icon2x'], 'getIcon2x', 'test-icon2x'];
        yield 'icon3xAbsent' => [[], 'getIcon3x', null];
        yield 'icon3xWrongType' => [[SchemaAppTransformerInterface::KEY_ICON3X => 42], 'getIcon3x', null];
        yield 'icon3xValid' => [[SchemaAppTransformerInterface::KEY_ICON3X => 'test-icon3x'], 'getIcon3x', 'test-icon3x'];
        yield 'oAuthClientIdAbsent' => [[], 'getOAuthClientId', null];
        yield 'oAuthClientIdWrongType' => [[SchemaAppTransformerInterface::KEY_O_AUTH_CLIENT_ID => 42], 'getOAuthClientId', null];
        yield 'oAuthClientIdValid' => [[SchemaAppTransformerInterface::KEY_O_AUTH_CLIENT_ID => 'test-o-auth-client-id'], 'getOAuthClientId', 'test-o-auth-client-id'];
        yield 'oAuthClientSecretAbsent' => [[], 'getOAuthClientSecret', null];
        yield 'oAuthClientSecretWrongType' => [[SchemaAppTransformerInterface::KEY_O_AUTH_CLIENT_SECRET => 42], 'getOAuthClientSecret', null];
        yield 'oAuthClientSecretValid' => [[SchemaAppTransformerInterface::KEY_O_AUTH_CLIENT_SECRET => 'test-o-auth-client-secret'], 'getOAuthClientSecret', 'test-o-auth-client-secret'];
        yield 'oAuthTokenUrlAbsent' => [[], 'getOAuthTokenUrl', null];
        yield 'oAuthTokenUrlWrongType' => [[SchemaAppTransformerInterface::KEY_O_AUTH_TOKEN_URL => 42], 'getOAuthTokenUrl', null];
        yield 'oAuthTokenUrlValid' => [[SchemaAppTransformerInterface::KEY_O_AUTH_TOKEN_URL => 'test-o-auth-token-url'], 'getOAuthTokenUrl', 'test-o-auth-token-url'];
        yield 'organizationIdAbsent' => [[], 'getOrganizationId', null];
        yield 'organizationIdWrongType' => [[SchemaAppTransformerInterface::KEY_ORGANIZATION_ID => 42], 'getOrganizationId', null];
        yield 'organizationIdValid' => [[SchemaAppTransformerInterface::KEY_ORGANIZATION_ID => 'test-organization-id'], 'getOrganizationId', 'test-organization-id'];
        yield 'oAuthScopeAbsent' => [[], 'getOAuthScope', null];
        yield 'oAuthScopeWrongType' => [[SchemaAppTransformerInterface::KEY_O_AUTH_SCOPE => 42], 'getOAuthScope', null];
        yield 'oAuthScopeValid' => [[SchemaAppTransformerInterface::KEY_O_AUTH_SCOPE => 'test-o-auth-scope'], 'getOAuthScope', 'test-o-auth-scope'];
        yield 'userIdAbsent' => [[], 'getUserId', null];
        yield 'userIdWrongType' => [[SchemaAppTransformerInterface::KEY_USER_ID => 42], 'getUserId', null];
        yield 'userIdValid' => [[SchemaAppTransformerInterface::KEY_USER_ID => 'test-user-id'], 'getUserId', 'test-user-id'];
        yield 'hostingTypeAbsent' => [[], 'getHostingType', null];
        yield 'hostingTypeWrongType' => [[SchemaAppTransformerInterface::KEY_HOSTING_TYPE => 42], 'getHostingType', null];
        yield 'hostingTypeValid' => [[SchemaAppTransformerInterface::KEY_HOSTING_TYPE => 'test-hosting-type'], 'getHostingType', 'test-hosting-type'];
        yield 'schemaTypeAbsent' => [[], 'getSchemaType', null];
        yield 'schemaTypeWrongType' => [[SchemaAppTransformerInterface::KEY_SCHEMA_TYPE => 42], 'getSchemaType', null];
        yield 'schemaTypeValid' => [[SchemaAppTransformerInterface::KEY_SCHEMA_TYPE => 'test-schema-type'], 'getSchemaType', 'test-schema-type'];
        yield 'webhookUrlAbsent' => [[], 'getWebhookUrl', null];
        yield 'webhookUrlWrongType' => [[SchemaAppTransformerInterface::KEY_WEBHOOK_URL => 42], 'getWebhookUrl', null];
        yield 'webhookUrlValid' => [[SchemaAppTransformerInterface::KEY_WEBHOOK_URL => 'test-webhook-url'], 'getWebhookUrl', 'test-webhook-url'];
        yield 'userEmailAbsent' => [[], 'getUserEmail', null];
        yield 'userEmailWrongType' => [[SchemaAppTransformerInterface::KEY_USER_EMAIL => 42], 'getUserEmail', null];
        yield 'userEmailValid' => [[SchemaAppTransformerInterface::KEY_USER_EMAIL => 'test-user-email'], 'getUserEmail', 'test-user-email'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $viperAppLinks = self::createStub(ViperAppLinksInterface::class);
        $details = self::createStub(SchemaAppDetailsInterface::class);
        $details->method('getViperAppLinks')->willReturn($viperAppLinks);

        $data = [SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'] + [SchemaAppTransformerInterface::KEY_VIPER_APP_LINKS => []];
        $containerTransformer = self::createMock(SchemaAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new SchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($viperAppLinks, $actual->getViperAppLinks());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(SchemaAppDetailsInterface::class);
        $containerTransformer = self::createStub(SchemaAppDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new SchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform([SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'] + [SchemaAppTransformerInterface::KEY_VIPER_APP_LINKS => []]);

        self::assertNull($actual->getViperAppLinks());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(SchemaAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new SchemaAppTransformer($containerTransformer);

        $actual = $transformer->transform([SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id']);

        self::assertNull($actual->getViperAppLinks());
    }
}
