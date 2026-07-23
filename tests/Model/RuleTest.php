<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Rule;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Rule::class)]
final class RuleTest extends TestCase
{
    public function test(): void
    {
        $rule = new Rule('test-rule-id');
        self::assertSame('test-rule-id', $rule->getId());
        self::assertNull($rule->getName());
        self::assertNull($rule->getStatus());

        self::assertSame($rule, $rule->setId('test-new-rule-id'));
        self::assertSame($rule, $rule->setName('test-name'));
        self::assertSame($rule, $rule->setStatus('Enabled'));

        self::assertSame('test-new-rule-id', $rule->getId());
        self::assertSame('test-name', $rule->getName());
        self::assertSame('Enabled', $rule->getStatus());
    }
}
