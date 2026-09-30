<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Model\RuleListQuery;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RuleApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
#[CoversClass(RuleListQuery::class)]
final class RuleApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [RuleApiInterface::API_URL.'?locationId=test-location', [], $this->headers(), [RuleApiInterface::KEY_ITEMS => ['plain']]],
                [RuleApiInterface::API_URL.'?includeAllParents=true&max=20&offset=40&locationId=test-location', [], $this->headers(), [RuleApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(RuleInterface::class)];
        $variant = [self::createStub(RuleInterface::class)];
        $transformer = self::createStub(RulesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $query = (new RuleListQuery())->setIncludeAllParents(true)->setMax(20)->setOffset(40);
        $api = $this->api($requestSender, rulesTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple('test-location'));
        self::assertSame($variant, $api->getMultiple('test-location', false, $query));
        self::assertSame($plain, $api->getMultiple('test-location'));
        self::assertSame($variant, $api->getMultiple('test-location', false, $query));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?RuleTransformerInterface $ruleTransformer = null, ?RulesTransformerInterface $rulesTransformer = null, ?RuleExecutionResultTransformerInterface $ruleExecutionResultTransformer = null, ?RuleRequestSerializerInterface $ruleRequestSerializer = null): RuleApi
    {
        return new RuleApi($requestSender, $ruleTransformer ?? self::createStub(RuleTransformerInterface::class), $rulesTransformer ?? self::createStub(RulesTransformerInterface::class), new Token('test-api-token'), $ruleExecutionResultTransformer ?? self::createStub(RuleExecutionResultTransformerInterface::class), $ruleRequestSerializer ?? self::createStub(RuleRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
