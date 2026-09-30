<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\StringConfig;
use ChristianBrown\SmartThings\Model\StringConfigInterface;

final class StringConfigTransformer implements StringConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StringConfigInterface
    {
        return (new StringConfig())
            ->setValue($this->valueReader->string($data, self::KEY_VALUE));
    }
}
