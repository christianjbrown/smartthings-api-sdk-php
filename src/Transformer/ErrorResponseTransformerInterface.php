<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ErrorResponseInterface;

interface ErrorResponseTransformerInterface
{
    public const string KEY_ERROR = 'error';
    public const string KEY_REQUEST_ID = 'requestId';

    /**
     * Reads an error body, for instance the decoded body of a failed request:
     * `$transformer->transform($exception->getDecodedBody() ?? [])`.
     *
     * @param mixed[] $data
     */
    public function transform(array $data): ErrorResponseInterface;
}
