<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\OrganizationApi;
use ChristianBrown\SmartThings\Api\OrganizationApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(OrganizationApi::class)]
#[CoversClass(Token::class)]
final class OrganizationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            OrganizationApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                OrganizationApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $organizations = [self::createStub(OrganizationInterface::class), self::createStub(OrganizationInterface::class)];

        $organizationsTransformer = self::createMock(OrganizationsTransformerInterface::class);
        $organizationsTransformer->expects(self::once())->method('transform')
            ->with($data[OrganizationApiInterface::KEY_ITEMS])
            ->willReturn($organizations);

        $organizationApi = new OrganizationApi($requestSender, self::createStub(OrganizationTransformerInterface::class), $organizationsTransformer, new Token('test-api-token'));
        $actual = $organizationApi->getMultiple();

        self::assertSame($organizations, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            OrganizationApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $organizations = [self::createStub(OrganizationInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $organizationsTransformer = self::createMock(OrganizationsTransformerInterface::class);
        $organizationsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[OrganizationApiInterface::KEY_ITEMS])
            ->willReturn($organizations);

        $organizationApi = new OrganizationApi($requestSender, self::createStub(OrganizationTransformerInterface::class), $organizationsTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($organizations, $organizationApi->getMultiple());
        self::assertSame($organizations, $organizationApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            OrganizationApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $organizations = [self::createStub(OrganizationInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $organizationsTransformer = self::createMock(OrganizationsTransformerInterface::class);
        $organizationsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[OrganizationApiInterface::KEY_ITEMS])
            ->willReturn($organizations);

        $organizationApi = new OrganizationApi($requestSender, self::createStub(OrganizationTransformerInterface::class), $organizationsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($organizations, $organizationApi->getMultiple());
        self::assertSame($organizations, $organizationApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[OrganizationApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[OrganizationApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $organizationApi = new OrganizationApi($requestSender, self::createStub(OrganizationTransformerInterface::class), self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrganizationApiInterface::UNEXPECTED_RESPONSE_SPRINTF, OrganizationApiInterface::KEY_ITEMS));
        $organizationApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-organization-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(OrganizationApiInterface::API_URL_SPRINTF, 'test-organization-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $organization = self::createStub(OrganizationInterface::class);

        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($organization);

        $organizationApi = new OrganizationApi($requestSender, $organizationTransformer, self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));
        $actual = $organizationApi->getOneById('test-organization-id');

        self::assertSame($organization, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-organization-data'];

        $organization = self::createStub(OrganizationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($organization);

        $organizationApi = new OrganizationApi($requestSender, $organizationTransformer, self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($organization, $organizationApi->getOneById('test-organization-id'));
        self::assertSame($organization, $organizationApi->getOneById('test-organization-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../organizations'])]
    public function testGetOneByIdEncodesId(string $organizationId): void
    {
        $data = ['test-organization-data'];

        $organization = self::createStub(OrganizationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(OrganizationApiInterface::API_URL_SPRINTF, rawurlencode($organizationId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($organization);

        $organizationApi = new OrganizationApi($requestSender, $organizationTransformer, self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));
        $actual = $organizationApi->getOneById($organizationId);

        self::assertSame($organization, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-organization-data'];

        $organization = self::createStub(OrganizationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $organizationTransformer = self::createMock(OrganizationTransformerInterface::class);
        $organizationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($organization);

        $organizationApi = new OrganizationApi($requestSender, $organizationTransformer, self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($organization, $organizationApi->getOneById('test-organization-id'));
        self::assertSame($organization, $organizationApi->getOneById('test-organization-id', true));
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

        $organizationApi = new OrganizationApi($requestSender, self::createStub(OrganizationTransformerInterface::class), self::createStub(OrganizationsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(OrganizationApiInterface::UNEXPECTED_RESPONSE);
        $organizationApi->getOneById('test-organization-id', $skipCache);
    }
}
