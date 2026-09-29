<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusLightColorControlColorInterface
{
    public function getHue(): ?string;

    public function getSaturation(): ?string;

    public function setHue(?string $value): self;

    public function setSaturation(?string $value): self;
}
