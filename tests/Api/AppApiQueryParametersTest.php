<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppListQuery;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AppApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
#[CoversClass(AppListQuery::class)]
final class AppApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [AppApiInterface::API_URL, [], $this->headers(), [AppApiInterface::KEY_ITEMS => ['plain']]],
                [AppApiInterface::API_URL.'?accountId=test-account&appType=WEBHOOK_SMART_APP&classification=SERVICE&tag=test-tag', [], $this->headers(), [AppApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(AppInterface::class)];
        $variant = [self::createStub(AppInterface::class)];
        $transformer = self::createStub(AppsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $query = (new AppListQuery())->setAccountId('test-account')->setAppType('WEBHOOK_SMART_APP')->setClassification('SERVICE')->setTag('test-tag');
        $api = $this->api($requestSender, $transformer, self::createStub(AppOauthTransformerInterface::class));

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, $query));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, $query));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOauthSendsConsistentRead(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(AppApiInterface::API_URL_OAUTH_SPRINTF, 'test-app').'?consistentRead=true', [], $this->headers())
            ->willReturn(['test-oauth-data']);
        $oauth = self::createStub(AppOauthInterface::class);
        $transformer = self::createStub(AppOauthTransformerInterface::class);
        $transformer->method('transform')->willReturn($oauth);

        self::assertSame($oauth, $this->api($requestSender, self::createStub(AppsTransformerInterface::class), $transformer)->getOauth('test-app', false, true));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, AppsTransformerInterface $appsTransformer, AppOauthTransformerInterface $appOauthTransformer): AppApi
    {
        return new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
