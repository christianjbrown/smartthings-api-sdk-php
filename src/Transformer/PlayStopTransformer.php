<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PlayStop;
use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;
use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PlayStopStateInterface;

use function is_array;

final class PlayStopTransformer implements PlayStopTransformerInterface
{
    private PlayStopCommandTransformerInterface $playStopCommandTransformer;
    private PlayStopStateTransformerInterface $playStopStateTransformer;

    public function __construct(PlayStopCommandTransformerInterface $playStopCommandTransformer, PlayStopStateTransformerInterface $playStopStateTransformer)
    {
        $this->playStopCommandTransformer = $playStopCommandTransformer;
        $this->playStopStateTransformer = $playStopStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayStopInterface
    {
        $model = new PlayStop($this->requireCommand($data), $this->requireState($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ?PlayStopCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return null;
        }

        return $this->playStopCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireState(array $data): ?PlayStopStateInterface
    {
        if (!isset($data[self::KEY_STATE])) {
            return null;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return null;
        }

        return $this->playStopStateTransformer->transform($data[self::KEY_STATE]);
    }
}
