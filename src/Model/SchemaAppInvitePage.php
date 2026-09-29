<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInvitePage implements SchemaAppInvitePageInterface
{
    /**
     * @var null|array<int, SchemaAppInviteInterface>
     */
    private ?array $items = null;
    private ?PageLinksInterface $links = null;

    /**
     * @return null|array<int, SchemaAppInviteInterface>
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    public function getLinks(): ?PageLinksInterface
    {
        return $this->links;
    }

    /**
     * @param null|array<int, SchemaAppInviteInterface> $value
     */
    public function setItems(?array $value): SchemaAppInvitePageInterface
    {
        $this->items = $value;

        return $this;
    }

    public function setLinks(?PageLinksInterface $value): SchemaAppInvitePageInterface
    {
        $this->links = $value;

        return $this;
    }
}
