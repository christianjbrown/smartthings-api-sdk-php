<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ModeConfig;
use ChristianBrown\SmartThings\Model\ModeConfigInterface;

final class ModeConfigTransformer implements ModeConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ModeConfigInterface
    {
        return (new ModeConfig())
            ->setModeId($this->valueReader->string($data, self::KEY_MODE_ID));
    }
}
