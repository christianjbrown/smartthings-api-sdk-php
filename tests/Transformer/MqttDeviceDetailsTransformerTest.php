<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MqttDeviceDetails;
use ChristianBrown\SmartThings\Transformer\MqttDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MqttDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MqttDeviceDetails::class)]
#[CoversClass(MqttDeviceDetailsTransformer::class)]
final class MqttDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            MqttDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            MqttDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            MqttDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => true,
        ];

        $transformer = new MqttDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertTrue($actual->getTransferCandidate());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MqttDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[MqttDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[MqttDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[MqttDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[MqttDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'transferCandidateAbsent' => [[], 'getTransferCandidate', null];
        yield 'transferCandidateWrongType' => [[MqttDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => 'not-bool'], 'getTransferCandidate', null];
        yield 'transferCandidateValid' => [[MqttDeviceDetailsTransformerInterface::KEY_TRANSFER_CANDIDATE => true], 'getTransferCandidate', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new MqttDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getHubId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getTransferCandidate());
    }
}
