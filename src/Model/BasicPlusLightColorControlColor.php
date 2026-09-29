<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusLightColorControlColor implements BasicPlusLightColorControlColorInterface
{
    private ?string $hue = null;
    private ?string $saturation = null;

    public function getHue(): ?string
    {
        return $this->hue;
    }

    public function getSaturation(): ?string
    {
        return $this->saturation;
    }

    public function setHue(?string $value): BasicPlusLightColorControlColorInterface
    {
        $this->hue = $value;

        return $this;
    }

    public function setSaturation(?string $value): BasicPlusLightColorControlColorInterface
    {
        $this->saturation = $value;

        return $this;
    }
}
