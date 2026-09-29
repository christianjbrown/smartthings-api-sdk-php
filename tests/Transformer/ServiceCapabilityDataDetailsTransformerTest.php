<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataDetails;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityDataDetails::class)]
#[CoversClass(ServiceCapabilityDataDetailsTransformer::class)]
final class ServiceCapabilityDataDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $serviceCapabilityDataAlertItemModel = self::createStub(ServiceCapabilityDataAlertItemInterface::class);
        $serviceCapabilityDataAlertItemTransformer = self::createStub(ServiceCapabilityDataAlertItemTransformerInterface::class);
        $serviceCapabilityDataAlertItemTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemModel);
        $data = [
            ServiceCapabilityDataDetailsTransformerInterface::KEY_ALERT => [['test-nested']],
        ];

        $transformer = new ServiceCapabilityDataDetailsTransformer($serviceCapabilityDataAlertItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$serviceCapabilityDataAlertItemModel], $actual->getAlert());
    }

    public function testTransformAlert(): void
    {
        $serviceCapabilityDataAlertItemModel = self::createStub(ServiceCapabilityDataAlertItemInterface::class);
        $serviceCapabilityDataAlertItemTransformer = self::createStub(ServiceCapabilityDataAlertItemTransformerInterface::class);
        $serviceCapabilityDataAlertItemTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemModel);
        $transformer = new ServiceCapabilityDataDetailsTransformer($serviceCapabilityDataAlertItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAlert());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataDetailsTransformerInterface::KEY_ALERT => 'test-not-array'])->getAlert());
        self::assertSame([$serviceCapabilityDataAlertItemModel], $transformer->transform($base + [ServiceCapabilityDataDetailsTransformerInterface::KEY_ALERT => [['test-nested'], 'test-skipped']])->getAlert());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $serviceCapabilityDataAlertItemModel = self::createStub(ServiceCapabilityDataAlertItemInterface::class);
        $serviceCapabilityDataAlertItemTransformer = self::createStub(ServiceCapabilityDataAlertItemTransformerInterface::class);
        $serviceCapabilityDataAlertItemTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemModel);
        $transformer = new ServiceCapabilityDataDetailsTransformer($serviceCapabilityDataAlertItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getAlert());
    }
}
