<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IndoorMapInterface
{
    /**
     * @return null|mixed[]
     */
    public function getCoordinates(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getData(): ?array;

    /**
     * @return null|mixed[]
     */
    public function getRotation(): ?array;

    public function getVisible(): ?bool;

    /**
     * @param null|mixed[] $value
     */
    public function setCoordinates(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRotation(?array $value): self;

    public function setVisible(?bool $value): self;
}
