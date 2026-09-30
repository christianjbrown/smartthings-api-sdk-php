<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationListQueryInterface extends QueryParametersInterface
{
    public const string KEY_ALLOWED = 'allowed';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_PAGE = 'page';

    public function getAllowed(): ?bool;

    public function getLimit(): ?int;

    public function getPage(): ?string;

    public function setAllowed(?bool $value): self;

    public function setLimit(?int $value): self;

    public function setPage(?string $value): self;
}
