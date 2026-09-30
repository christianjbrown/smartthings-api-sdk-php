<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SleepActionExecutionResult;
use ChristianBrown\SmartThings\Model\SleepActionExecutionResultInterface;

final class SleepActionExecutionResultTransformer implements SleepActionExecutionResultTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SleepActionExecutionResultInterface
    {
        return (new SleepActionExecutionResult())
            ->setResult($this->valueReader->string($data, self::KEY_RESULT));
    }
}
