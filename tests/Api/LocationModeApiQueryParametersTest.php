<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocationModeApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class LocationModeApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteModeSendsRequestId(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-mode-id').'?requestId=test-request', [], $this->headers())
            ->willReturn([]);
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location-id');

        $this->api($requestSender)->deleteMode($location, 'test-mode-id', 'test-request');
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?ModeTransformerInterface $modeTransformer = null, ?ModesTransformerInterface $modesTransformer = null): LocationModeApi
    {
        return new LocationModeApi($requestSender, $modeTransformer ?? self::createStub(ModeTransformerInterface::class), $modesTransformer ?? self::createStub(ModesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
