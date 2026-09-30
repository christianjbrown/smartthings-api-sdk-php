<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppListQuery implements AppListQueryInterface
{
    private ?string $accountId = null;
    private ?string $appType = null;
    private ?string $classification = null;
    private ?string $tag = null;

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function getAppType(): ?string
    {
        return $this->appType;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_ACCOUNT_ID => $this->accountId,
            self::KEY_APP_TYPE => $this->appType,
            self::KEY_CLASSIFICATION => $this->classification,
            self::KEY_TAG => $this->tag,
        ];
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setAccountId(?string $value): AppListQueryInterface
    {
        $this->accountId = $value;

        return $this;
    }

    public function setAppType(?string $value): AppListQueryInterface
    {
        $this->appType = $value;

        return $this;
    }

    public function setClassification(?string $value): AppListQueryInterface
    {
        $this->classification = $value;

        return $this;
    }

    public function setTag(?string $value): AppListQueryInterface
    {
        $this->tag = $value;

        return $this;
    }
}
