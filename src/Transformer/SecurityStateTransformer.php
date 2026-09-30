<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SecurityState;
use ChristianBrown\SmartThings\Model\SecurityStateInterface;

final class SecurityStateTransformer implements SecurityStateTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SecurityStateInterface
    {
        return (new SecurityState())
            ->setArmState($this->valueReader->string($data, self::KEY_ARM_STATE))
            ->setMonitoring($this->valueReader->bool($data, self::KEY_MONITORING));
    }
}
