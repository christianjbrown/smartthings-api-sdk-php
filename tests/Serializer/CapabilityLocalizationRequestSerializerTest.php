<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18n;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalization;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLabel;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalization;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalization;
use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequest;
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityArgumentI18n::class)]
#[CoversClass(CapabilityArgumentLocalization::class)]
#[CoversClass(CapabilityAttributeLabel::class)]
#[CoversClass(CapabilityAttributeLocalization::class)]
#[CoversClass(CapabilityCommandLocalization::class)]
#[CoversClass(CapabilityLocalizationRequest::class)]
#[CoversClass(CapabilityLocalizationRequestSerializer::class)]
final class CapabilityLocalizationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CapabilityLocalizationRequest('test-tag');

        $serializer = new CapabilityLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CapabilityLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CapabilityLocalizationRequest('test-tag'))
            ->setLabel('test-label')
            ->setDescription('test-description')
            ->setAttributes(['test-key' => (new CapabilityAttributeLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setDisplayTemplate('test-display-template')
                ->setI18n(['test-key' => ['test-inner-key' => (new CapabilityAttributeLabel('test-label'))
                    ->setDescription('test-description')]])])
            ->setCommands(['test-key' => (new CapabilityCommandLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setArguments(['test-key' => (new CapabilityArgumentLocalization())
                    ->setI18n(['test-key' => new CapabilityArgumentI18n('test-label')])
                    ->setLabel('test-label')
                    ->setDescription('test-description')])]);

        $serializer = new CapabilityLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CapabilityLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CapabilityLocalizationRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DISPLAY_TEMPLATE => 'test-display-template',
                    CapabilityLocalizationRequestSerializerInterface::KEY_I18N => ['test-key' => ['test-inner-key' => [
                        CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    ]]],
                ]],
                CapabilityLocalizationRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_ARGUMENTS => ['test-key' => [
                        CapabilityLocalizationRequestSerializerInterface::KEY_I18N => ['test-key' => [
                            CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        ]],
                        CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    ]],
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new CapabilityLocalizationRequest('test-tag'))
            ->setLabel('test-label')
            ->setDescription('test-description')
            ->setAttributes(['test-key' => new CapabilityAttributeLocalization()])
            ->setCommands(['test-key' => new CapabilityCommandLocalization()]);

        $serializer = new CapabilityLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CapabilityLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CapabilityLocalizationRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => []],
                CapabilityLocalizationRequestSerializerInterface::KEY_COMMANDS => ['test-key' => []],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth2(): void
    {
        $request = (new CapabilityLocalizationRequest('test-tag'))
            ->setLabel('test-label')
            ->setDescription('test-description')
            ->setAttributes(['test-key' => (new CapabilityAttributeLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setDisplayTemplate('test-display-template')
                ->setI18n(['test-key' => ['test-inner-key' => new CapabilityAttributeLabel('test-label')]])])
            ->setCommands(['test-key' => (new CapabilityCommandLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setArguments(['test-key' => new CapabilityArgumentLocalization()])]);

        $serializer = new CapabilityLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CapabilityLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CapabilityLocalizationRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DISPLAY_TEMPLATE => 'test-display-template',
                    CapabilityLocalizationRequestSerializerInterface::KEY_I18N => ['test-key' => ['test-inner-key' => [
                        CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    ]]],
                ]],
                CapabilityLocalizationRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_ARGUMENTS => ['test-key' => []],
                ]],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth3(): void
    {
        $request = (new CapabilityLocalizationRequest('test-tag'))
            ->setLabel('test-label')
            ->setDescription('test-description')
            ->setAttributes(['test-key' => (new CapabilityAttributeLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setDisplayTemplate('test-display-template')
                ->setI18n(['test-key' => ['test-inner-key' => (new CapabilityAttributeLabel('test-label'))
                    ->setDescription('test-description')]])])
            ->setCommands(['test-key' => (new CapabilityCommandLocalization())
                ->setLabel('test-label')
                ->setDescription('test-description')
                ->setArguments(['test-key' => (new CapabilityArgumentLocalization())
                    ->setI18n(['test-key' => new CapabilityArgumentI18n('test-label')])
                    ->setLabel('test-label')
                    ->setDescription('test-description')])]);

        $serializer = new CapabilityLocalizationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CapabilityLocalizationRequestSerializerInterface::KEY_TAG => 'test-tag',
                CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CapabilityLocalizationRequestSerializerInterface::KEY_ATTRIBUTES => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DISPLAY_TEMPLATE => 'test-display-template',
                    CapabilityLocalizationRequestSerializerInterface::KEY_I18N => ['test-key' => ['test-inner-key' => [
                        CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    ]]],
                ]],
                CapabilityLocalizationRequestSerializerInterface::KEY_COMMANDS => ['test-key' => [
                    CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                    CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    CapabilityLocalizationRequestSerializerInterface::KEY_ARGUMENTS => ['test-key' => [
                        CapabilityLocalizationRequestSerializerInterface::KEY_I18N => ['test-key' => [
                            CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        ]],
                        CapabilityLocalizationRequestSerializerInterface::KEY_LABEL => 'test-label',
                        CapabilityLocalizationRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                    ]],
                ]],
            ],
            $actual
        );
    }
}
