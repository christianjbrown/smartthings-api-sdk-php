<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ViperAppLinksInterface;

interface ViperAppLinksTransformerInterface
{
    public const string KEY_ANDROID = 'android';
    public const string KEY_IOS = 'ios';
    public const string KEY_IS_LINKING_ENABLED = 'isLinkingEnabled';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ViperAppLinksInterface;
}
