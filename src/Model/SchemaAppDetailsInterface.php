<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppDetailsInterface
{
    public function getViperAppLinks(): ?ViperAppLinksInterface;

    public function setViperAppLinks(?ViperAppLinksInterface $value): self;
}
