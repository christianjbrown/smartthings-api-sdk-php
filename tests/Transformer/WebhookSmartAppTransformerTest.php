<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\WebhookSmartApp;
use ChristianBrown\SmartThings\Transformer\WebhookSmartAppTransformer;
use ChristianBrown\SmartThings\Transformer\WebhookSmartAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(WebhookSmartApp::class)]
#[CoversClass(WebhookSmartAppTransformer::class)]
final class WebhookSmartAppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            WebhookSmartAppTransformerInterface::KEY_TARGET_URL => 'test-target-url',
            WebhookSmartAppTransformerInterface::KEY_TARGET_STATUS => 'test-target-status',
            WebhookSmartAppTransformerInterface::KEY_PUBLIC_KEY => 'test-public-key',
            WebhookSmartAppTransformerInterface::KEY_SIGNATURE_TYPE => 'test-signature-type',
        ];

        $transformer = new WebhookSmartAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-target-url', $actual->getTargetUrl());
        self::assertSame('test-target-status', $actual->getTargetStatus());
        self::assertSame('test-public-key', $actual->getPublicKey());
        self::assertSame('test-signature-type', $actual->getSignatureType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new WebhookSmartAppTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'targetUrlAbsent' => [[], 'getTargetUrl', null];
        yield 'targetUrlWrongType' => [[WebhookSmartAppTransformerInterface::KEY_TARGET_URL => 42], 'getTargetUrl', null];
        yield 'targetUrlValid' => [[WebhookSmartAppTransformerInterface::KEY_TARGET_URL => 'test-target-url'], 'getTargetUrl', 'test-target-url'];
        yield 'targetStatusAbsent' => [[], 'getTargetStatus', null];
        yield 'targetStatusWrongType' => [[WebhookSmartAppTransformerInterface::KEY_TARGET_STATUS => 42], 'getTargetStatus', null];
        yield 'targetStatusValid' => [[WebhookSmartAppTransformerInterface::KEY_TARGET_STATUS => 'test-target-status'], 'getTargetStatus', 'test-target-status'];
        yield 'publicKeyAbsent' => [[], 'getPublicKey', null];
        yield 'publicKeyWrongType' => [[WebhookSmartAppTransformerInterface::KEY_PUBLIC_KEY => 42], 'getPublicKey', null];
        yield 'publicKeyValid' => [[WebhookSmartAppTransformerInterface::KEY_PUBLIC_KEY => 'test-public-key'], 'getPublicKey', 'test-public-key'];
        yield 'signatureTypeAbsent' => [[], 'getSignatureType', null];
        yield 'signatureTypeWrongType' => [[WebhookSmartAppTransformerInterface::KEY_SIGNATURE_TYPE => 42], 'getSignatureType', null];
        yield 'signatureTypeValid' => [[WebhookSmartAppTransformerInterface::KEY_SIGNATURE_TYPE => 'test-signature-type'], 'getSignatureType', 'test-signature-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new WebhookSmartAppTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getTargetUrl());
        self::assertNull($actual->getTargetStatus());
        self::assertNull($actual->getPublicKey());
        self::assertNull($actual->getSignatureType());
    }
}
