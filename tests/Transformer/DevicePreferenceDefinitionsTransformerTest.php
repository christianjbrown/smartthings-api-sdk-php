<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePreferenceDefinitionsTransformer::class)]
final class DevicePreferenceDefinitionsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-definition-1'], ['test-definition-2']];

        $first = self::createStub(DevicePreferenceDefinitionInterface::class);
        $second = self::createStub(DevicePreferenceDefinitionInterface::class);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new DevicePreferenceDefinitionsTransformer($definitionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::never())
            ->method('transform');

        $transformer = new DevicePreferenceDefinitionsTransformer($definitionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $definitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);

        $transformer = new DevicePreferenceDefinitionsTransformer($definitionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceDefinitionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DevicePreferenceDefinitionsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
