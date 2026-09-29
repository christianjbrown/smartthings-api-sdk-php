<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppDetails implements SchemaAppDetailsInterface
{
    private ?ViperAppLinksInterface $viperAppLinks = null;

    public function getViperAppLinks(): ?ViperAppLinksInterface
    {
        return $this->viperAppLinks;
    }

    public function setViperAppLinks(?ViperAppLinksInterface $value): SchemaAppDetailsInterface
    {
        $this->viperAppLinks = $value;

        return $this;
    }
}
