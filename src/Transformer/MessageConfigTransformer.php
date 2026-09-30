<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MessageConfig;
use ChristianBrown\SmartThings\Model\MessageConfigInterface;

final class MessageConfigTransformer implements MessageConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MessageConfigInterface
    {
        return (new MessageConfig())
            ->setMessageGroupKey($this->valueReader->string($data, self::KEY_MESSAGE_GROUP_KEY));
    }
}
