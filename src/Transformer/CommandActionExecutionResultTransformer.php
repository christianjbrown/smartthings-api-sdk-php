<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandActionExecutionResult;
use ChristianBrown\SmartThings\Model\CommandActionExecutionResultInterface;

final class CommandActionExecutionResultTransformer implements CommandActionExecutionResultTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandActionExecutionResultInterface
    {
        return (new CommandActionExecutionResult())
            ->setResult($this->valueReader->string($data, self::KEY_RESULT))
            ->setDeviceId($this->valueReader->string($data, self::KEY_DEVICE_ID))
            ->setComponent($this->valueReader->string($data, self::KEY_COMPONENT))
            ->setCapability($this->valueReader->string($data, self::KEY_CAPABILITY))
            ->setCommand($this->valueReader->string($data, self::KEY_COMMAND))
            ->setArguments($this->valueReader->records($data, self::KEY_ARGUMENTS));
    }
}
