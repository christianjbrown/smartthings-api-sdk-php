<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IndoorMap implements IndoorMapInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $coordinates = null;

    /**
     * @var null|mixed[]
     */
    private ?array $data = null;

    /**
     * @var null|mixed[]
     */
    private ?array $rotation = null;
    private ?bool $visible = null;

    /**
     * @return null|mixed[]
     */
    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    /**
     * @return null|mixed[]
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return null|mixed[]
     */
    public function getRotation(): ?array
    {
        return $this->rotation;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setCoordinates(?array $value): IndoorMapInterface
    {
        $this->coordinates = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): IndoorMapInterface
    {
        $this->data = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRotation(?array $value): IndoorMapInterface
    {
        $this->rotation = $value;

        return $this;
    }

    public function setVisible(?bool $value): IndoorMapInterface
    {
        $this->visible = $value;

        return $this;
    }
}
