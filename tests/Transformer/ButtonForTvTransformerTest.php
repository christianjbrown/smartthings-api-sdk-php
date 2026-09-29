<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ButtonForTv;
use ChristianBrown\SmartThings\Transformer\ButtonForTvTransformer;
use ChristianBrown\SmartThings\Transformer\ButtonForTvTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ButtonForTv::class)]
#[CoversClass(ButtonForTvTransformer::class)]
final class ButtonForTvTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ButtonForTvTransformerInterface::KEY_VERSION => 7,
            ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component',
            ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command',
            ButtonForTvTransformerInterface::KEY_ARGUMENT => 'test-argument',
            ButtonForTvTransformerInterface::KEY_ICON_URL => 'test-icon-url',
        ];

        $transformer = new ButtonForTvTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-argument', $actual->getArgument());
        self::assertSame('test-icon-url', $actual->getIconUrl());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ButtonForTvTransformer();

        $actual = $transformer->transform([ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ButtonForTvTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ButtonForTvTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'argumentAbsent' => [[], 'getArgument', null];
        yield 'argumentWrongType' => [[ButtonForTvTransformerInterface::KEY_ARGUMENT => 42], 'getArgument', null];
        yield 'argumentValid' => [[ButtonForTvTransformerInterface::KEY_ARGUMENT => 'test-argument'], 'getArgument', 'test-argument'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[ButtonForTvTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[ButtonForTvTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ButtonForTvTransformer();

        $actual = $transformer->transform([ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getArgument());
        self::assertNull($actual->getIconUrl());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ButtonForTvTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command', ButtonForTvTransformerInterface::KEY_CAPABILITY => 42], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMMAND => 'test-command', ButtonForTvTransformerInterface::KEY_COMPONENT => 42], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_COMPONENT)];
        yield 'commandAbsent' => [[ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[ButtonForTvTransformerInterface::KEY_CAPABILITY => 'test-capability', ButtonForTvTransformerInterface::KEY_COMPONENT => 'test-component', ButtonForTvTransformerInterface::KEY_COMMAND => 42], sprintf(ButtonForTvTransformerInterface::UNEXPECTED_STRING_SPRINTF, ButtonForTvTransformerInterface::KEY_COMMAND)];
    }
}
