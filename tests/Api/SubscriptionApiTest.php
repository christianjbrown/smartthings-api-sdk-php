<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApi;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetail;
use ChristianBrown\SmartThings\Model\DeviceHealthDetail;
use ChristianBrown\SmartThings\Model\DeviceLifecycleDetail;
use ChristianBrown\SmartThings\Model\DeviceSubscriptionDetail;
use ChristianBrown\SmartThings\Model\HubHealthDetail;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetail;
use ChristianBrown\SmartThings\Model\SceneLifecycleDetail;
use ChristianBrown\SmartThings\Model\SecurityArmStateDetail;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;
use ChristianBrown\SmartThings\Model\SubscriptionRequest;
use ChristianBrown\SmartThings\Model\SubscriptionRequestInterface;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializer;
use ChristianBrown\SmartThings\Serializer\SubscriptionRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(SubscriptionRequestSerializer::class)]
#[CoversClass(SceneLifecycleDetail::class)]
#[CoversClass(HubHealthDetail::class)]
#[CoversClass(SecurityArmStateDetail::class)]
#[CoversClass(DeviceHealthDetail::class)]
#[CoversClass(DeviceLifecycleDetail::class)]
#[CoversClass(ModeSubscriptionDetail::class)]
#[CoversClass(CapabilitySubscriptionDetail::class)]
#[CoversClass(DeviceSubscriptionDetail::class)]
#[CoversClass(SubscriptionRequest::class)]
#[CoversClass(SubscriptionApi::class)]
#[CoversClass(Token::class)]
final class SubscriptionApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllSubscriptions(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_LIST_SPRINTF, 'test-installed-app-id'),
                [SubscriptionApiInterface::KEY_DEVICE_ID => 'test-device-id', SubscriptionApiInterface::KEY_MODE_ID => 'test-mode-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $api->deleteAllSubscriptions('test-installed-app-id', 'test-device-id', 'test-mode-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllSubscriptionsInvalidatesCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $api->getOneById('test-installed-app-id', 'test-subscription-id');
        $api->deleteAllSubscriptions('test-installed-app-id');
        $api->getOneById('test-installed-app-id', 'test-subscription-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllSubscriptionsWithoutOptionalQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_LIST_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $api->deleteAllSubscriptions('test-installed-app-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteSubscription(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_SPRINTF, 'test-installed-app-id', 'test-subscription-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $api->deleteSubscription('test-installed-app-id', 'test-subscription-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteSubscriptionInvalidatesCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $api->getOneById('test-installed-app-id', 'test-subscription-id');
        $api->deleteSubscription('test-installed-app-id', 'test-subscription-id');
        $api->getOneById('test-installed-app-id', 'test-subscription-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            SubscriptionApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_LIST_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $subscriptions = [self::createStub(SubscriptionInterface::class), self::createStub(SubscriptionInterface::class)];

        $subscriptionsTransformer = self::createMock(SubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::once())->method('transform')
            ->with($data[SubscriptionApiInterface::KEY_ITEMS])
            ->willReturn($subscriptions);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), $subscriptionsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('test-installed-app-id');

        self::assertSame($subscriptions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            SubscriptionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $subscriptions = [self::createStub(SubscriptionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $subscriptionsTransformer = self::createMock(SubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[SubscriptionApiInterface::KEY_ITEMS])
            ->willReturn($subscriptions);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), $subscriptionsTransformer, new Token('test-api-token'));

        // Second call for the same installed app is served from the cache without hitting the API.
        self::assertSame($subscriptions, $api->getMultiple('test-installed-app-id'));
        self::assertSame($subscriptions, $api->getMultiple('test-installed-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleEncodesInstalledAppId(): void
    {
        $data = [
            SubscriptionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $subscriptions = [self::createStub(SubscriptionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_LIST_SPRINTF, rawurlencode('a/b c')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $subscriptionsTransformer = self::createMock(SubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::once())->method('transform')
            ->with($data[SubscriptionApiInterface::KEY_ITEMS])
            ->willReturn($subscriptions);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), $subscriptionsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('a/b c');

        self::assertSame($subscriptions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            SubscriptionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $subscriptions = [self::createStub(SubscriptionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $subscriptionsTransformer = self::createMock(SubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[SubscriptionApiInterface::KEY_ITEMS])
            ->willReturn($subscriptions);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), $subscriptionsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($subscriptions, $api->getMultiple('test-installed-app-id'));
        self::assertSame($subscriptions, $api->getMultiple('test-installed-app-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[SubscriptionApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[SubscriptionApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SubscriptionApiInterface::UNEXPECTED_RESPONSE_SPRINTF, SubscriptionApiInterface::KEY_ITEMS));
        $api->getMultiple('test-installed-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-subscription-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_SPRINTF, 'test-installed-app-id', 'test-subscription-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $subscription = self::createStub(SubscriptionInterface::class);

        $subscriptionTransformer = self::createMock(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($subscription);

        $api = new SubscriptionApi($requestSender, $subscriptionTransformer, self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById('test-installed-app-id', 'test-subscription-id');

        self::assertSame($subscription, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-subscription-data'];

        $subscription = self::createStub(SubscriptionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $subscriptionTransformer = self::createMock(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($subscription);

        $api = new SubscriptionApi($requestSender, $subscriptionTransformer, self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same ids is served from the cache without hitting the API.
        self::assertSame($subscription, $api->getOneById('test-installed-app-id', 'test-subscription-id'));
        self::assertSame($subscription, $api->getOneById('test-installed-app-id', 'test-subscription-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../installedapps', '../../subscriptions'])]
    public function testGetOneByIdEncodesIds(string $installedAppId, string $subscriptionId): void
    {
        $data = ['test-subscription-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_SPRINTF, rawurlencode($installedAppId), rawurlencode($subscriptionId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $subscription = self::createStub(SubscriptionInterface::class);

        $subscriptionTransformer = self::createMock(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($subscription);

        $api = new SubscriptionApi($requestSender, $subscriptionTransformer, self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById($installedAppId, $subscriptionId);

        self::assertSame($subscription, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-subscription-data'];

        $subscription = self::createStub(SubscriptionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $subscriptionTransformer = self::createMock(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($subscription);

        $api = new SubscriptionApi($requestSender, $subscriptionTransformer, self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($subscription, $api->getOneById('test-installed-app-id', 'test-subscription-id'));
        self::assertSame($subscription, $api->getOneById('test-installed-app-id', 'test-subscription-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SubscriptionApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-installed-app-id', 'test-subscription-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testSaveSubscription(): void
    {
        $data = ['test-data'];

        $request = self::createStub(SubscriptionRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(SubscriptionApiInterface::API_URL_LIST_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(SubscriptionRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(SubscriptionInterface::class);

        $transformer = self::createMock(SubscriptionTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SubscriptionApi($requestSender, $transformer, self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'), $serializer);
        $actual = $api->saveSubscription('test-installed-app-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testSaveSubscriptionInvalidatesListCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([SubscriptionApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $api->getMultiple('test-installed-app-id');
        $api->saveSubscription('test-installed-app-id', self::createStub(SubscriptionRequestInterface::class));
        $api->getMultiple('test-installed-app-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testSaveSubscriptionUnexpectedResponse(): void
    {
        $request = self::createStub(SubscriptionRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SubscriptionApiInterface::UNEXPECTED_RESPONSE);
        $api->saveSubscription('test-installed-app-id', $request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testSaveSubscriptionUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new SubscriptionApi($requestSender, self::createStub(SubscriptionTransformerInterface::class), self::createStub(SubscriptionsTransformerInterface::class), new Token('test-api-token'));
        $api->saveSubscription('test-installed-app-id', new SubscriptionRequest('test-source-type'));

        $this->addToAssertionCount(1);
    }
}
