<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ApiErrorInterface;

/**
 * Reads the API's Error and InstalledAppLifecycleError objects, which share one shape.
 */
interface ApiErrorTransformerInterface
{
    public const string KEY_CODE = 'code';
    public const string KEY_DETAILS = 'details';
    public const string KEY_MESSAGE = 'message';
    public const string KEY_TARGET = 'target';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ApiErrorInterface;
}
