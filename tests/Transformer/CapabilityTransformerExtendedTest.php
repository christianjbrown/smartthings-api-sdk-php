<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Capability;
use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandInterface;
use ChristianBrown\SmartThings\Model\CapabilityDetailsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Capability::class)]
#[CoversClass(CapabilityTransformer::class)]
final class CapabilityTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityTransformer(self::createStub(CapabilityDetailsTransformerInterface::class));

        $actual = $transformer->transform([CapabilityTransformerInterface::KEY_ID => 'test-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'ephemeralAbsent' => [[], 'getEphemeral', null];
        yield 'ephemeralWrongType' => [[CapabilityTransformerInterface::KEY_EPHEMERAL => 'not-bool'], 'getEphemeral', null];
        yield 'ephemeralValid' => [[CapabilityTransformerInterface::KEY_EPHEMERAL => true], 'getEphemeral', true];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $attributes = [self::createStub(CapabilityAttributeInterface::class)];
        $commands = [self::createStub(CapabilityCommandInterface::class)];
        $details = self::createStub(CapabilityDetailsInterface::class);
        $details->method('getAttributes')->willReturn($attributes);
        $details->method('getCommands')->willReturn($commands);

        $data = [CapabilityTransformerInterface::KEY_ID => 'test-id'] + [CapabilityTransformerInterface::KEY_ATTRIBUTES => []];
        $containerTransformer = self::createMock(CapabilityDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new CapabilityTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($attributes, $actual->getAttributes());
        self::assertSame($commands, $actual->getCommands());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(CapabilityDetailsInterface::class);
        $containerTransformer = self::createStub(CapabilityDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new CapabilityTransformer($containerTransformer);

        $actual = $transformer->transform([CapabilityTransformerInterface::KEY_ID => 'test-id'] + [CapabilityTransformerInterface::KEY_ATTRIBUTES => []]);

        self::assertSame([], $actual->getAttributes());
        self::assertSame([], $actual->getCommands());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(CapabilityDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new CapabilityTransformer($containerTransformer);

        $actual = $transformer->transform([CapabilityTransformerInterface::KEY_ID => 'test-id']);

        self::assertSame([], $actual->getAttributes());
        self::assertSame([], $actual->getCommands());
    }
}
