<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequest;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalization;
use ChristianBrown\SmartThings\Serializer\PreferenceLocalizationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PreferenceLocalizationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PreferenceLocalizationRequest::class)]
#[CoversClass(PreferenceOptionLocalization::class)]
#[CoversClass(PreferenceLocalizationRequestSerializer::class)]
final class PreferenceLocalizationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new PreferenceLocalizationRequest('test-tag', 'test-label');

        $serializer = new PreferenceLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PreferenceLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                PreferenceLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new PreferenceLocalizationRequest('test-tag', 'test-label'))
            ->setDescription('test-description')
            ->setOptions(['test-key' => new PreferenceOptionLocalization('test-label')]);

        $serializer = new PreferenceLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PreferenceLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                PreferenceLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                PreferenceLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                PreferenceLocalizationRequestSerializerInterface::KEY_OPTIONS => ['test-key' => [
                    PreferenceLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new PreferenceLocalizationRequest('test-tag', 'test-label'))
            ->setDescription('test-description')
            ->setOptions(['test-key' => new PreferenceOptionLocalization('test-label')]);

        $serializer = new PreferenceLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PreferenceLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                PreferenceLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                PreferenceLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                PreferenceLocalizationRequestSerializerInterface::KEY_OPTIONS => ['test-key' => [
                    PreferenceLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                ]],
            ],
            $actual
        );
    }
}
