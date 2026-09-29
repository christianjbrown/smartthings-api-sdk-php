<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControl;
use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlColorTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusLightColorControlTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusLightColorControl::class)]
#[CoversClass(BasicPlusLightColorControlTransformer::class)]
final class BasicPlusLightColorControlTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusLightColorControlColorModel = self::createStub(BasicPlusLightColorControlColorInterface::class);
        $basicPlusLightColorControlColorTransformer = self::createStub(BasicPlusLightColorControlColorTransformerInterface::class);
        $basicPlusLightColorControlColorTransformer->method('transform')->willReturn($basicPlusLightColorControlColorModel);
        $data = [
            BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusLightColorControlTransformerInterface::KEY_VERSION => 7,
            BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command',
            BasicPlusLightColorControlTransformerInterface::KEY_VALUE => 'test-value',
            BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested'],
        ];

        $transformer = new BasicPlusLightColorControlTransformer($basicPlusLightColorControlColorTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame($basicPlusLightColorControlColorModel, $actual->getColor());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusLightColorControlTransformer(self::createStub(BasicPlusLightColorControlColorTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusLightColorControlTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[BasicPlusLightColorControlTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusLightColorControlColorModel = self::createStub(BasicPlusLightColorControlColorInterface::class);
        $basicPlusLightColorControlColorTransformer = self::createStub(BasicPlusLightColorControlColorTransformerInterface::class);
        $basicPlusLightColorControlColorTransformer->method('transform')->willReturn($basicPlusLightColorControlColorModel);
        $transformer = new BasicPlusLightColorControlTransformer($basicPlusLightColorControlColorTransformer);

        $actual = $transformer->transform([BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested']]);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusLightColorControlTransformer(self::createStub(BasicPlusLightColorControlColorTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'componentAbsent' => [[BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested']], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested'], BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 42], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested']], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested'], BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 42], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY)];
        yield 'commandAbsent' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested']], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => ['test-nested'], BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 42], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COMMAND)];
        yield 'colorAbsent' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COLOR)];
        yield 'colorWrongType' => [[BasicPlusLightColorControlTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusLightColorControlTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusLightColorControlTransformerInterface::KEY_COMMAND => 'test-command', BasicPlusLightColorControlTransformerInterface::KEY_COLOR => 'not-array'], sprintf(BasicPlusLightColorControlTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, BasicPlusLightColorControlTransformerInterface::KEY_COLOR)];
    }
}
