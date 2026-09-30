<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ErrorResponse;
use ChristianBrown\SmartThings\Model\ErrorResponseInterface;

final class ErrorResponseTransformer implements ErrorResponseTransformerInterface
{
    private ApiErrorTransformerInterface $apiErrorTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(ApiErrorTransformerInterface $apiErrorTransformer, ValueReaderInterface $valueReader)
    {
        $this->apiErrorTransformer = $apiErrorTransformer;
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorResponseInterface
    {
        $error = $this->valueReader->record($data, self::KEY_ERROR);

        return (new ErrorResponse())
            ->setRequestId($this->valueReader->string($data, self::KEY_REQUEST_ID))
            ->setError(null === $error ? null : $this->apiErrorTransformer->transform($error));
    }
}
