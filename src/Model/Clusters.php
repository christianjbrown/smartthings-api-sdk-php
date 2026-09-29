<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Clusters implements ClustersInterface
{
    /**
     * @var null|array<int, int>
     */
    private ?array $client = null;

    /**
     * @var null|array<int, int>
     */
    private ?array $server = null;

    /**
     * @return null|array<int, int>
     */
    public function getClient(): ?array
    {
        return $this->client;
    }

    /**
     * @return null|array<int, int>
     */
    public function getServer(): ?array
    {
        return $this->server;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setClient(?array $value): ClustersInterface
    {
        $this->client = $value;

        return $this;
    }

    /**
     * @param null|array<int, int> $value
     */
    public function setServer(?array $value): ClustersInterface
    {
        $this->server = $value;

        return $this;
    }
}
