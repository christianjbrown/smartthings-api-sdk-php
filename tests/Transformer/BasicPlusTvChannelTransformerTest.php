<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusTvChannel;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvChannelTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvChannelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusTvChannel::class)]
#[CoversClass(BasicPlusTvChannelTransformer::class)]
final class BasicPlusTvChannelTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandTransformer = self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class);
        $basicPlusTvVolumeCommandTransformer->method('transform')->willReturn($basicPlusTvVolumeCommandModel);
        $data = [
            BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusTvChannelTransformerInterface::KEY_VERSION => 7,
            BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusTvChannelTransformerInterface::KEY_LABEL => 'test-label',
            BasicPlusTvChannelTransformerInterface::KEY_VALUE => 'test-value',
            BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested'],
        ];

        $transformer = new BasicPlusTvChannelTransformer($basicPlusTvVolumeCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame($basicPlusTvVolumeCommandModel, $actual->getCommand());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvChannelTransformer(self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusTvChannelTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[BasicPlusTvChannelTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[BasicPlusTvChannelTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandTransformer = self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class);
        $basicPlusTvVolumeCommandTransformer->method('transform')->willReturn($basicPlusTvVolumeCommandModel);
        $transformer = new BasicPlusTvChannelTransformer($basicPlusTvVolumeCommandTransformer);

        $actual = $transformer->transform([BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusTvChannelTransformer(self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested']], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 42], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested']], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 42], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_COMPONENT)];
        yield 'commandAbsent' => [[BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[BasicPlusTvChannelTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvChannelTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvChannelTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(BasicPlusTvChannelTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, BasicPlusTvChannelTransformerInterface::KEY_COMMAND)];
    }
}
