<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandClasses implements CommandClassesInterface
{
    /**
     * @var null|array<int, int>
     */
    private ?array $controlled = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $either = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $supported = null;

    /**
     * @return null|array<int, int>
     */
    public function getControlled(): ?array
    {
        return $this->controlled;
    }

    /**
     * @return null|array<int, int>
     */
    public function getEither(): ?array
    {
        return $this->either;
    }

    /**
     * @return null|array<int, int>
     */
    public function getSupported(): ?array
    {
        return $this->supported;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setControlled(?array $value): CommandClassesInterface
    {
        $this->controlled = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setEither(?array $value): CommandClassesInterface
    {
        $this->either = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setSupported(?array $value): CommandClassesInterface
    {
        $this->supported = $value;

        return $this;
    }
}
