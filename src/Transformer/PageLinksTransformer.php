<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PageLinks;
use ChristianBrown\SmartThings\Model\PageLinksInterface;

use function is_array;

final class PageLinksTransformer implements PageLinksTransformerInterface
{
    private PageLinkTransformerInterface $pageLinkTransformer;

    public function __construct(PageLinkTransformerInterface $pageLinkTransformer)
    {
        $this->pageLinkTransformer = $pageLinkTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PageLinksInterface
    {
        $model = new PageLinks();

        $this->applyNext($model, $data);
        $this->applyPrevious($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNext(PageLinks $model, array $data): void
    {
        if (!isset($data[self::KEY_NEXT])) {
            return;
        }
        if (!is_array($data[self::KEY_NEXT])) {
            return;
        }
        $model->setNext($this->pageLinkTransformer->transform($data[self::KEY_NEXT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrevious(PageLinks $model, array $data): void
    {
        if (!isset($data[self::KEY_PREVIOUS])) {
            return;
        }
        if (!is_array($data[self::KEY_PREVIOUS])) {
            return;
        }
        $model->setPrevious($this->pageLinkTransformer->transform($data[self::KEY_PREVIOUS]));
    }
}
