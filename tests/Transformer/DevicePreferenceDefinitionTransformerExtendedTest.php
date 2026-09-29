<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinition;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DevicePreferenceDefinition::class)]
#[CoversClass(DevicePreferenceDefinitionTransformer::class)]
final class DevicePreferenceDefinitionTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DevicePreferenceDefinitionTransformer();

        $actual = $transformer->transform([DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_ID => 'test-preference-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'explicitAbsent' => [[], 'getExplicit', null];
        yield 'explicitWrongType' => [[DevicePreferenceDefinitionTransformerInterface::KEY_EXPLICIT => 'not-bool'], 'getExplicit', null];
        yield 'explicitValid' => [[DevicePreferenceDefinitionTransformerInterface::KEY_EXPLICIT => true], 'getExplicit', true];
    }
}
