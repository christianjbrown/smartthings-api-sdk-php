<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePreferencesTransformer::class)]
final class DevicePreferencesTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [
            DevicePreferencesTransformerInterface::KEY_VALUES => [
                'motionSensitivity' => [DevicePreferenceTransformerInterface::KEY_VALUE => 5],
                'tempOffset' => [DevicePreferenceTransformerInterface::KEY_VALUE => 1.5],
            ],
        ];

        $motionSensitivity = self::createStub(DevicePreferenceInterface::class);
        $tempOffset = self::createStub(DevicePreferenceInterface::class);

        $preferenceTransformer = self::createMock(DevicePreferenceTransformerInterface::class);
        $preferenceTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturnCallback(static function (array $preferenceData) use ($motionSensitivity, $tempOffset): DevicePreferenceInterface {
                // The map key is injected as the preference name for the singular transformer.
                self::assertArrayHasKey(DevicePreferenceTransformerInterface::KEY_NAME, $preferenceData);

                return 'motionSensitivity' === $preferenceData[DevicePreferenceTransformerInterface::KEY_NAME] ? $motionSensitivity : $tempOffset;
            });

        $transformer = new DevicePreferencesTransformer($preferenceTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$motionSensitivity, $tempOffset], $actual);
    }

    /**
     * @throws Exception
     */
    public function testTransformEmptyValues(): void
    {
        $preferenceTransformer = self::createMock(DevicePreferenceTransformerInterface::class);
        $preferenceTransformer->expects(self::never())
            ->method('transform');

        $transformer = new DevicePreferencesTransformer($preferenceTransformer);

        self::assertSame([], $transformer->transform([DevicePreferencesTransformerInterface::KEY_VALUES => []]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $preferenceTransformer = self::createStub(DevicePreferenceTransformerInterface::class);

        $transformer = new DevicePreferencesTransformer($preferenceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DevicePreferencesTransformerInterface::ARRAY_NAME));
        $transformer->transform([DevicePreferencesTransformerInterface::KEY_VALUES => ['motionSensitivity' => 'not-an-array']]);
    }

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[DevicePreferencesTransformerInterface::KEY_VALUES => 'not-an-array']])]
    public function testTransformUnexpectedValues(array $data): void
    {
        $preferenceTransformer = self::createStub(DevicePreferenceTransformerInterface::class);

        $transformer = new DevicePreferencesTransformer($preferenceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferencesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DevicePreferencesTransformerInterface::KEY_VALUES));
        $transformer->transform($data);
    }
}
