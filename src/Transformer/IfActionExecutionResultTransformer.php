<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IfActionExecutionResult;
use ChristianBrown\SmartThings\Model\IfActionExecutionResultInterface;

final class IfActionExecutionResultTransformer implements IfActionExecutionResultTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IfActionExecutionResultInterface
    {
        return (new IfActionExecutionResult())
            ->setResult($this->valueReader->string($data, self::KEY_RESULT));
    }
}
