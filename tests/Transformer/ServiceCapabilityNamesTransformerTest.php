<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceCapabilityNamesTransformer::class)]
final class ServiceCapabilityNamesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ServiceCapabilityNamesTransformerInterface::KEY_NAME => ['weather', 'airQuality', 'forecast'],
        ];

        $transformer = new ServiceCapabilityNamesTransformer();

        self::assertSame(['weather', 'airQuality', 'forecast'], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $transformer = new ServiceCapabilityNamesTransformer();

        self::assertSame([], $transformer->transform([ServiceCapabilityNamesTransformerInterface::KEY_NAME => []]));
    }

    /**
     * @param mixed[] $names
     */
    #[TestWith([[42]])]
    #[TestWith([['weather', 42]])]
    public function testTransformUnexpectedElement(array $names): void
    {
        $transformer = new ServiceCapabilityNamesTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceCapabilityNamesTransformerInterface::UNEXPECTED_STRING_SPRINTF, ServiceCapabilityNamesTransformerInterface::ARRAY_NAME));
        $transformer->transform([ServiceCapabilityNamesTransformerInterface::KEY_NAME => $names]);
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ServiceCapabilityNamesTransformerInterface::KEY_NAME => 'not-an-array']])]
    public function testTransformUnexpectedName(array $data): void
    {
        $transformer = new ServiceCapabilityNamesTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceCapabilityNamesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ServiceCapabilityNamesTransformerInterface::KEY_NAME));
        $transformer->transform($data);
    }
}
