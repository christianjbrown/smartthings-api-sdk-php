<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinition;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePreferenceDefinition::class)]
#[CoversClass(DevicePreferenceDefinitionTransformer::class)]
final class DevicePreferenceDefinitionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_ID => 'test-preference-id',
            DevicePreferenceDefinitionTransformerInterface::KEY_DESCRIPTION => 'Test description',
            DevicePreferenceDefinitionTransformerInterface::KEY_NAME => 'tempOffset',
            DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_TYPE => 'integer',
            DevicePreferenceDefinitionTransformerInterface::KEY_REQUIRED => true,
            DevicePreferenceDefinitionTransformerInterface::KEY_TITLE => 'Temperature Offset',
        ];

        $transformer = new DevicePreferenceDefinitionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-preference-id', $actual->getPreferenceId());
        self::assertSame('Test description', $actual->getDescription());
        self::assertSame('tempOffset', $actual->getName());
        self::assertSame('integer', $actual->getPreferenceType());
        self::assertTrue($actual->getRequired());
        self::assertSame('Temperature Offset', $actual->getTitle());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches,
     * including the falsy-but-legitimate `false` for the required flag.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedDescription, ?string $expectedName, ?string $expectedPreferenceType, ?bool $expectedRequired, ?string $expectedTitle): void
    {
        $transformer = new DevicePreferenceDefinitionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-preference-id', $actual->getPreferenceId());
        self::assertSame($expectedDescription, $actual->getDescription());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedPreferenceType, $actual->getPreferenceType());
        self::assertSame($expectedRequired, $actual->getRequired());
        self::assertSame($expectedTitle, $actual->getTitle());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?bool, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_ID;
        $description = DevicePreferenceDefinitionTransformerInterface::KEY_DESCRIPTION;
        $name = DevicePreferenceDefinitionTransformerInterface::KEY_NAME;
        $type = DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_TYPE;
        $required = DevicePreferenceDefinitionTransformerInterface::KEY_REQUIRED;
        $title = DevicePreferenceDefinitionTransformerInterface::KEY_TITLE;

        yield 'allAbsent' => [[$id => 'test-preference-id'], null, null, null, null, null];
        yield 'allValid' => [[$id => 'test-preference-id', $description => 'Test description', $name => 'tempOffset', $type => 'integer', $required => true, $title => 'Temperature Offset'], 'Test description', 'tempOffset', 'integer', true, 'Temperature Offset'];
        yield 'requiredFalse' => [[$id => 'test-preference-id', $required => false], null, null, null, false, null];
        yield 'requiredWrongType' => [[$id => 'test-preference-id', $required => 'not-a-bool'], null, null, null, null, null];
        yield 'descriptionWrongType' => [[$id => 'test-preference-id', $description => 42], null, null, null, null, null];
        yield 'nameWrongType' => [[$id => 'test-preference-id', $name => 42], null, null, null, null, null];
        yield 'preferenceTypeWrongType' => [[$id => 'test-preference-id', $type => 42], null, null, null, null, null];
        yield 'titleWrongType' => [[$id => 'test-preference-id', $title => 42], null, null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DevicePreferenceDefinitionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceDefinitionTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePreferenceDefinitionTransformerInterface::KEY_PREFERENCE_ID));
        $transformer->transform($data);
    }
}
