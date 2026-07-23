<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DeviceProfileApi::class)]
#[CoversClass(Token::class)]
final class DeviceProfileApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceProfileApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profiles = [self::createStub(DeviceProfileInterface::class), self::createStub(DeviceProfileInterface::class)];

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));
        $actual = $profileApi->getMultiple();

        self::assertSame($profiles, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $profiles = [self::createStub(DeviceProfileInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($profiles, $profileApi->getMultiple());
        self::assertSame($profiles, $profileApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $profiles = [self::createStub(DeviceProfileInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($profiles, $profileApi->getMultiple());
        self::assertSame($profiles, $profileApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceProfileApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfileApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceProfileApiInterface::KEY_ITEMS));
        $profileApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-profile-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profile = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));
        $actual = $profileApi->getOneById('test-profile-id');

        self::assertSame($profile, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-profile-data'];

        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../deviceprofiles'])]
    public function testGetOneByIdEncodesId(string $deviceProfileId): void
    {
        $data = ['test-profile-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, rawurlencode($deviceProfileId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profile = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));
        $actual = $profileApi->getOneById($deviceProfileId);

        self::assertSame($profile, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-profile-data'];

        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
        self::assertSame($profile, $profileApi->getOneById('test-profile-id', true));
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
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceProfileApiInterface::UNEXPECTED_RESPONSE);
        $profileApi->getOneById('test-profile-id', $skipCache);
    }
}
