<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ApiError;
use ChristianBrown\SmartThings\Model\ApiErrorInterface;

use function array_map;

final class ApiErrorTransformer implements ApiErrorTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ApiErrorInterface
    {
        return (new ApiError())
            ->setCode($this->valueReader->string($data, self::KEY_CODE))
            ->setMessage($this->valueReader->string($data, self::KEY_MESSAGE))
            ->setTarget($this->valueReader->string($data, self::KEY_TARGET))
            ->setDetails(array_map(fn (array $detail): ApiErrorInterface => $this->transform($detail), $this->valueReader->records($data, self::KEY_DETAILS)));
    }
}
