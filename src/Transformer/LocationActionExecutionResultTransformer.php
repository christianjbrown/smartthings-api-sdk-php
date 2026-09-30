<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationActionExecutionResult;
use ChristianBrown\SmartThings\Model\LocationActionExecutionResultInterface;

final class LocationActionExecutionResultTransformer implements LocationActionExecutionResultTransformerInterface
{
    private SecurityStateTransformerInterface $securityStateTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader, SecurityStateTransformerInterface $securityStateTransformer)
    {
        $this->valueReader = $valueReader;
        $this->securityStateTransformer = $securityStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationActionExecutionResultInterface
    {
        $security = $this->valueReader->record($data, self::KEY_SECURITY);

        return (new LocationActionExecutionResult())
            ->setResult($this->valueReader->string($data, self::KEY_RESULT))
            ->setLocationId($this->valueReader->string($data, self::KEY_LOCATION_ID))
            ->setMode($this->valueReader->string($data, self::KEY_MODE))
            ->setSecurity(null === $security ? null : $this->securityStateTransformer->transform($security));
    }
}
