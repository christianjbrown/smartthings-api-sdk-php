<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DriverApi;
use ChristianBrown\SmartThings\Api\DriverApiInterface;
use ChristianBrown\SmartThings\Api\DriverPackageUploaderInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Transformer\DriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DriverApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class DriverApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSendsDriverIds(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [DriverApiInterface::API_URL, [], $this->headers(), [DriverApiInterface::KEY_ITEMS => ['plain']]],
                [DriverApiInterface::API_URL.'?driverIds=one&driverIds=two', [], $this->headers(), [DriverApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(DriverInterface::class)];
        $variant = [self::createStub(DriverInterface::class)];
        $transformer = self::createStub(DriversTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, driversTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, ['one', 'two']));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, ['one', 'two']));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?DriverTransformerInterface $driverTransformer = null, ?DriversTransformerInterface $driversTransformer = null, ?DriverPackageUploaderInterface $driverPackageUploader = null): DriverApi
    {
        return new DriverApi($requestSender, $driverTransformer ?? self::createStub(DriverTransformerInterface::class), $driversTransformer ?? self::createStub(DriversTransformerInterface::class), new Token('test-api-token'), $driverPackageUploader ?? self::createStub(DriverPackageUploaderInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
