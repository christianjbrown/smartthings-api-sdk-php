<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Localization;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Localization::class)]
#[CoversClass(LocalizationTransformer::class)]
final class LocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LocalizationTransformerInterface::KEY_TAG => 'fr',
            LocalizationTransformerInterface::KEY_LABEL => 'Sensibilité au mouvement',
            LocalizationTransformerInterface::KEY_DESCRIPTION => 'Une description',
        ];

        $transformer = new LocalizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('fr', $actual->getTag());
        self::assertSame('Sensibilité au mouvement', $actual->getLabel());
        self::assertSame('Une description', $actual->getDescription());
    }

    /**
     * Exercises the optional label/description fields (absent / wrong-type / valid).
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedLabel, ?string $expectedDescription): void
    {
        $transformer = new LocalizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('fr', $actual->getTag());
        self::assertSame($expectedLabel, $actual->getLabel());
        self::assertSame($expectedDescription, $actual->getDescription());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $tag = LocalizationTransformerInterface::KEY_TAG;
        $label = LocalizationTransformerInterface::KEY_LABEL;
        $description = LocalizationTransformerInterface::KEY_DESCRIPTION;

        yield 'allAbsent' => [[$tag => 'fr'], null, null];
        yield 'allValid' => [[$tag => 'fr', $label => 'Sensibilité au mouvement', $description => 'Une description'], 'Sensibilité au mouvement', 'Une description'];
        yield 'labelWrongType' => [[$tag => 'fr', $label => 42], null, null];
        yield 'descriptionWrongType' => [[$tag => 'fr', $description => 42], null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[LocalizationTransformerInterface::KEY_TAG => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new LocalizationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocalizationTransformerInterface::UNEXPECTED_STRING_SPRINTF, LocalizationTransformerInterface::KEY_TAG));
        $transformer->transform($data);
    }
}
