<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TtsInfo;
use ChristianBrown\SmartThings\Model\TtsInfoInterface;
use ChristianBrown\SmartThings\Model\TtsVoiceInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class TtsInfoTransformer implements TtsInfoTransformerInterface
{
    private TtsVoiceTransformerInterface $ttsVoiceTransformer;

    public function __construct(TtsVoiceTransformerInterface $ttsVoiceTransformer)
    {
        $this->ttsVoiceTransformer = $ttsVoiceTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TtsInfoInterface
    {
        $model = new TtsInfo();

        $this->applyVoices($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVoices(TtsInfo $model, array $data): void
    {
        if (!isset($data[self::KEY_VOICES])) {
            return;
        }
        if (!is_array($data[self::KEY_VOICES])) {
            return;
        }
        $model->setVoices($this->transformListTtsVoice($data[self::KEY_VOICES]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TtsVoiceInterface>
     */
    private function transformListTtsVoice(array $data): array
    {
        return array_values(array_map(fn (array $item): TtsVoiceInterface => $this->ttsVoiceTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
