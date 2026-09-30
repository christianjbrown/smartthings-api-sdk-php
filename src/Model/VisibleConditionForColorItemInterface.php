<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface VisibleConditionForColorItemInterface
{
    public function getOperand(): ?string;

    public function getOperator(): ?string;

    public function getReferTo(): ?VisibleConditionForColorItemReferToInterface;

    public function setReferTo(?VisibleConditionForColorItemReferToInterface $value): self;
}
