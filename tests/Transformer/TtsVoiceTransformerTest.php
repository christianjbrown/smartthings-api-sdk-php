<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\TtsVoice;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformer;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TtsVoice::class)]
#[CoversClass(TtsVoiceTransformer::class)]
final class TtsVoiceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender',
            TtsVoiceTransformerInterface::KEY_ID => 'test-id',
            TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code',
            TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name',
            TtsVoiceTransformerInterface::KEY_NAME => 'test-name',
            TtsVoiceTransformerInterface::KEY_SUPPORTED_ENGINES => ['test-supported-engines-1', 'test-supported-engines-2'],
            TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider',
            TtsVoiceTransformerInterface::KEY_SPEAKING_STYLE => ['test-speaking-style-1', 'test-speaking-style-2'],
        ];

        $transformer = new TtsVoiceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-gender', $actual->getGender());
        self::assertSame('test-id', $actual->getId());
        self::assertSame('test-language-code', $actual->getLanguageCode());
        self::assertSame('test-language-name', $actual->getLanguageName());
        self::assertSame('test-name', $actual->getName());
        self::assertSame(['test-supported-engines-1', 'test-supported-engines-2'], $actual->getSupportedEngines());
        self::assertSame('test-ttsprovider', $actual->getTtsProvider());
        self::assertSame(['test-speaking-style-1', 'test-speaking-style-2'], $actual->getSpeakingStyle());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new TtsVoiceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'genderAbsent' => [[TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'], 'getGender', null];
        yield 'genderWrongType' => [[TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider', TtsVoiceTransformerInterface::KEY_GENDER => 42], 'getGender', null];
        yield 'idAbsent' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'], 'getId', null];
        yield 'idWrongType' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider', TtsVoiceTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'languageCodeAbsent' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'], 'getLanguageCode', null];
        yield 'languageCodeWrongType' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 42], 'getLanguageCode', null];
        yield 'languageNameAbsent' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'], 'getLanguageName', null];
        yield 'languageNameWrongType' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 42], 'getLanguageName', null];
        yield 'nameAbsent' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'], 'getName', null];
        yield 'nameWrongType' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider', TtsVoiceTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'ttsProviderAbsent' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name'], 'getTtsProvider', null];
        yield 'ttsProviderWrongType' => [[TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 42], 'getTtsProvider', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TtsVoiceTransformer();

        $actual = $transformer->transform([TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'supportedEnginesAbsent' => [[], 'getSupportedEngines', null];
        yield 'supportedEnginesWrongType' => [[TtsVoiceTransformerInterface::KEY_SUPPORTED_ENGINES => 'not-array'], 'getSupportedEngines', null];
        yield 'supportedEnginesValid' => [[TtsVoiceTransformerInterface::KEY_SUPPORTED_ENGINES => ['test-supported-engines-1', 'test-supported-engines-2']], 'getSupportedEngines', ['test-supported-engines-1', 'test-supported-engines-2']];
        yield 'speakingStyleAbsent' => [[], 'getSpeakingStyle', null];
        yield 'speakingStyleWrongType' => [[TtsVoiceTransformerInterface::KEY_SPEAKING_STYLE => 'not-array'], 'getSpeakingStyle', null];
        yield 'speakingStyleValid' => [[TtsVoiceTransformerInterface::KEY_SPEAKING_STYLE => ['test-speaking-style-1', 'test-speaking-style-2']], 'getSpeakingStyle', ['test-speaking-style-1', 'test-speaking-style-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TtsVoiceTransformer();

        $actual = $transformer->transform([TtsVoiceTransformerInterface::KEY_GENDER => 'test-gender', TtsVoiceTransformerInterface::KEY_ID => 'test-id', TtsVoiceTransformerInterface::KEY_LANGUAGE_CODE => 'test-language-code', TtsVoiceTransformerInterface::KEY_LANGUAGE_NAME => 'test-language-name', TtsVoiceTransformerInterface::KEY_NAME => 'test-name', TtsVoiceTransformerInterface::KEY_TTSPROVIDER => 'test-ttsprovider']);

        self::assertNull($actual->getSupportedEngines());
        self::assertNull($actual->getSpeakingStyle());
    }
}
