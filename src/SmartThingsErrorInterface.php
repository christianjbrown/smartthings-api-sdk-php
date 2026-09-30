<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Transformer\ErrorResponseTransformerInterface;

interface SmartThingsErrorInterface
{
    public function getErrorResponseTransformer(): ErrorResponseTransformerInterface;
}
