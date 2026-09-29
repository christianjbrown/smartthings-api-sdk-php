<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ListForDetailView;
use ChristianBrown\SmartThings\Model\ListForDetailViewInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;

use function is_array;
use function sprintf;

final class ListForDetailViewTransformer implements ListForDetailViewTransformerInterface
{
    private ListWithAvailableSizeCommandTransformerInterface $listWithAvailableSizeCommandTransformer;
    private ListWithAvailableSizeStateTransformerInterface $listWithAvailableSizeStateTransformer;

    public function __construct(ListWithAvailableSizeCommandTransformerInterface $listWithAvailableSizeCommandTransformer, ListWithAvailableSizeStateTransformerInterface $listWithAvailableSizeStateTransformer)
    {
        $this->listWithAvailableSizeCommandTransformer = $listWithAvailableSizeCommandTransformer;
        $this->listWithAvailableSizeStateTransformer = $listWithAvailableSizeStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListForDetailViewInterface
    {
        $model = new ListForDetailView($this->requireCommand($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(ListForDetailView $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->listWithAvailableSizeStateTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ListWithAvailableSizeCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_COMMAND));
        }

        return $this->listWithAvailableSizeCommandTransformer->transform($data[self::KEY_COMMAND]);
    }
}
