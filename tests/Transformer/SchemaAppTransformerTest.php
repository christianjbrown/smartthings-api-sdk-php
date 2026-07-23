<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaApp;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaApp::class)]
#[CoversClass(SchemaAppTransformer::class)]
final class SchemaAppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
            SchemaAppTransformerInterface::KEY_APP_NAME => 'Lifx (Connect)',
            SchemaAppTransformerInterface::KEY_CERTIFICATION_STATUS => 'wwst',
            SchemaAppTransformerInterface::KEY_PARTNER_NAME => 'LIFX Inc.',
            SchemaAppTransformerInterface::KEY_ST_CLIENT_ID => 'test-client-id',
        ];

        $transformer = new SchemaAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-endpoint-app-id', $actual->getEndpointAppId());
        self::assertSame('Lifx (Connect)', $actual->getAppName());
        self::assertSame('wwst', $actual->getCertificationStatus());
        self::assertSame('LIFX Inc.', $actual->getPartnerName());
        self::assertSame('test-client-id', $actual->getStClientId());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedAppName, ?string $expectedCertificationStatus, ?string $expectedPartnerName, ?string $expectedStClientId): void
    {
        $transformer = new SchemaAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-endpoint-app-id', $actual->getEndpointAppId());
        self::assertSame($expectedAppName, $actual->getAppName());
        self::assertSame($expectedCertificationStatus, $actual->getCertificationStatus());
        self::assertSame($expectedPartnerName, $actual->getPartnerName());
        self::assertSame($expectedStClientId, $actual->getStClientId());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID;
        $appName = SchemaAppTransformerInterface::KEY_APP_NAME;
        $certification = SchemaAppTransformerInterface::KEY_CERTIFICATION_STATUS;
        $partnerName = SchemaAppTransformerInterface::KEY_PARTNER_NAME;
        $stClientId = SchemaAppTransformerInterface::KEY_ST_CLIENT_ID;

        yield 'allAbsent' => [[$id => 'test-endpoint-app-id'], null, null, null, null];
        yield 'allValid' => [[$id => 'test-endpoint-app-id', $appName => 'Lifx (Connect)', $certification => 'wwst', $partnerName => 'LIFX Inc.', $stClientId => 'test-client-id'], 'Lifx (Connect)', 'wwst', 'LIFX Inc.', 'test-client-id'];
        yield 'appNameWrongType' => [[$id => 'test-endpoint-app-id', $appName => 42], null, null, null, null];
        yield 'certificationStatusWrongType' => [[$id => 'test-endpoint-app-id', $certification => 42], null, null, null, null];
        yield 'partnerNameWrongType' => [[$id => 'test-endpoint-app-id', $partnerName => 42], null, null, null, null];
        yield 'stClientIdWrongType' => [[$id => 'test-endpoint-app-id', $stClientId => 42], null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new SchemaAppTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchemaAppTransformerInterface::UNEXPECTED_STRING_SPRINTF, SchemaAppTransformerInterface::KEY_ENDPOINT_APP_ID));
        $transformer->transform($data);
    }
}
