<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppDetails;
use ChristianBrown\SmartThings\Model\InstalledAppDetailsInterface;
use ChristianBrown\SmartThings\Model\NoticeInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class InstalledAppDetailsTransformer implements InstalledAppDetailsTransformerInterface
{
    private InstalledAppIconImageTransformerInterface $installedAppIconImageTransformer;
    private InstalledAppUiTransformerInterface $installedAppUiTransformer;
    private NoticeTransformerInterface $noticeTransformer;
    private OwnerTransformerInterface $ownerTransformer;

    public function __construct(OwnerTransformerInterface $ownerTransformer, NoticeTransformerInterface $noticeTransformer, InstalledAppUiTransformerInterface $installedAppUiTransformer, InstalledAppIconImageTransformerInterface $installedAppIconImageTransformer)
    {
        $this->ownerTransformer = $ownerTransformer;
        $this->noticeTransformer = $noticeTransformer;
        $this->installedAppUiTransformer = $installedAppUiTransformer;
        $this->installedAppIconImageTransformer = $installedAppIconImageTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppDetailsInterface
    {
        $model = new InstalledAppDetails();

        $this->applyOwner($model, $data);
        $this->applyNotices($model, $data);
        $this->applyUi($model, $data);
        $this->applyIconImage($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIconImage(InstalledAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ICON_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_ICON_IMAGE])) {
            return;
        }
        $model->setIconImage($this->installedAppIconImageTransformer->transform($data[self::KEY_ICON_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNotices(InstalledAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_NOTICES])) {
            return;
        }
        if (!is_array($data[self::KEY_NOTICES])) {
            return;
        }
        $model->setNotices($this->transformListNotice($data[self::KEY_NOTICES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOwner(InstalledAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_OWNER])) {
            return;
        }
        if (!is_array($data[self::KEY_OWNER])) {
            return;
        }
        $model->setOwner($this->ownerTransformer->transform($data[self::KEY_OWNER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUi(InstalledAppDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_UI])) {
            return;
        }
        if (!is_array($data[self::KEY_UI])) {
            return;
        }
        $model->setUi($this->installedAppUiTransformer->transform($data[self::KEY_UI]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, NoticeInterface>
     */
    private function transformListNotice(array $data): array
    {
        return array_values(array_map(fn (array $item): NoticeInterface => $this->noticeTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
