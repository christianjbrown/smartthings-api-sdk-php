<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContextInterface;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformerInterface;
use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\DriverPackageUploader;
use ChristianBrown\SmartThings\Api\DriverPackageUploaderInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverPackageUploader::class)]
#[CoversClass(ApiHost::class)]
final class DriverPackageUploaderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testUpload(): void
    {
        $requestSender = self::createMock(ApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                'https://test-host.example/v1/drivers/package',
                [],
                [
                    'Authorization' => 'Bearer test-api-token',
                    ApiRequestSenderInterface::HEADER_CONTENT_TYPE => DriverPackageUploaderInterface::CONTENT_TYPE_ZIP,
                ],
                'test-zip-contents'
            )
            ->willReturn('test-json');

        $responseTransformer = self::createMock(JsonToArrayTransformerInterface::class);
        $responseTransformer->expects(self::once())->method('transform')
            ->with(
                'test-json',
                self::callback(
                    static fn (RequestContextInterface $context): bool => ApiRequestSenderInterface::METHOD_POST === $context->getMethod()
                        && 'https://test-host.example/v1/drivers/package' === $context->getUrl()
                )
            )
            ->willReturn(['test-driver-data']);

        $uploader = new DriverPackageUploader($requestSender, $responseTransformer, new ApiHost('https://test-host.example'));

        self::assertSame(
            ['test-driver-data'],
            $uploader->upload(ApiHostInterface::PRODUCTION_BASE_URL.'/v1/drivers/package', ['Authorization' => 'Bearer test-api-token'], 'test-zip-contents')
        );
    }
}
