<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PageLinks implements PageLinksInterface
{
    private ?PageLinkInterface $next = null;
    private ?PageLinkInterface $previous = null;

    public function getNext(): ?PageLinkInterface
    {
        return $this->next;
    }

    public function getPrevious(): ?PageLinkInterface
    {
        return $this->previous;
    }

    public function setNext(?PageLinkInterface $value): PageLinksInterface
    {
        $this->next = $value;

        return $this;
    }

    public function setPrevious(?PageLinkInterface $value): PageLinksInterface
    {
        $this->previous = $value;

        return $this;
    }
}
