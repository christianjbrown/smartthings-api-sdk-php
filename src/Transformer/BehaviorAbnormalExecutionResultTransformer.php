<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BehaviorAbnormalExecutionResult;
use ChristianBrown\SmartThings\Model\BehaviorAbnormalExecutionResultInterface;

final class BehaviorAbnormalExecutionResultTransformer implements BehaviorAbnormalExecutionResultTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BehaviorAbnormalExecutionResultInterface
    {
        return (new BehaviorAbnormalExecutionResult())
            ->setResult($this->valueReader->string($data, self::KEY_RESULT))
            ->setReason($this->valueReader->string($data, self::KEY_REASON));
    }
}
