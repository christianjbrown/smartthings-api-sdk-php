<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PageLinksInterface
{
    public function getNext(): ?PageLinkInterface;

    public function getPrevious(): ?PageLinkInterface;

    public function setNext(?PageLinkInterface $value): self;

    public function setPrevious(?PageLinkInterface $value): self;
}
