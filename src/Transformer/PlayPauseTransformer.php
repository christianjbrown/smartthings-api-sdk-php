<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayPause;
use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;
use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayPauseStateInterface;

use function is_array;
use function sprintf;

final class PlayPauseTransformer implements PlayPauseTransformerInterface
{
    private PlayPauseCommandTransformerInterface $playPauseCommandTransformer;
    private PlayPauseStateTransformerInterface $playPauseStateTransformer;

    public function __construct(PlayPauseCommandTransformerInterface $playPauseCommandTransformer, PlayPauseStateTransformerInterface $playPauseStateTransformer)
    {
        $this->playPauseCommandTransformer = $playPauseCommandTransformer;
        $this->playPauseStateTransformer = $playPauseStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayPauseInterface
    {
        $model = new PlayPause($this->requireCommand($data), $this->requireState($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): PlayPauseCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->playPauseCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireState(array $data): PlayPauseStateInterface
    {
        if (!isset($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }
        if (!is_array($data[self::KEY_STATE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_STATE));
        }

        return $this->playPauseStateTransformer->transform($data[self::KEY_STATE]);
    }
}
