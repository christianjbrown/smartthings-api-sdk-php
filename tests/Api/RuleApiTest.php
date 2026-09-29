<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\RuleExecutionResult;
use ChristianBrown\SmartThings\Model\RuleExecutionResultInterface;
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Model\RuleRequest;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializer;
use ChristianBrown\SmartThings\Serializer\RuleRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\RuleExecutionResultTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(RuleApi::class)]
#[CoversClass(RuleExecutionResult::class)]
#[CoversClass(RuleExecutionResultTransformer::class)]
#[CoversClass(RuleRequest::class)]
#[CoversClass(RuleRequestSerializer::class)]
#[CoversClass(Token::class)]
final class RuleApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRule(): void
    {
        $data = ['test-rule-data'];

        $request = new RuleRequest('Test Rule', [['test-action']]);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                RuleApiInterface::API_URL,
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $ruleRequestSerializer = self::createMock(RuleRequestSerializerInterface::class);
        $ruleRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $rule = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), $ruleRequestSerializer);
        $actual = $ruleApi->createRule('test-location-id', $request);

        self::assertSame($rule, $actual);
    }

    /**
     * createRule() invalidates the cached rule list for this location, so a
     * subsequent getMultiple() call hits the API again instead of returning a stale
     * list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRuleInvalidatesListCache(): void
    {
        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([RuleApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-rule-data']);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $ruleTransformer->method('transform')
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);
        $rulesTransformer->method('transform')
            ->willReturn([$rule]);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $ruleApi->getMultiple('test-location-id');
        $ruleApi->createRule('test-location-id', new RuleRequest('Test Rule', [['test-action']]));
        $ruleApi->getMultiple('test-location-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRuleMissingLocationId(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->createRule('', new RuleRequest('Test Rule', [['test-action']]));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRuleUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(RuleApiInterface::UNEXPECTED_RESPONSE);
        $ruleApi->createRule('test-location-id', new RuleRequest('Test Rule', [['test-action']]));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllRules(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                RuleApiInterface::API_URL,
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));
        $ruleApi->deleteAllRules('test-location-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteAllRules() clears every cached rule and the cached list for this
     * location, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllRulesInvalidatesCaches(): void
    {
        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-rule-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $ruleTransformer->method('transform')
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $ruleApi->getOneById('test-rule-id', 'test-location-id');
        $ruleApi->deleteAllRules('test-location-id');
        $ruleApi->getOneById('test-rule-id', 'test-location-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAllRulesMissingLocationId(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->deleteAllRules('');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteRule(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(RuleApiInterface::API_URL_SPRINTF, 'test-rule-id'),
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));
        $ruleApi->deleteRule('test-rule-id', 'test-location-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteRule() invalidates the cached copy of this rule and the cached rule list
     * for this location, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteRuleInvalidatesCaches(): void
    {
        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-rule-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $ruleTransformer->method('transform')
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $ruleApi->getOneById('test-rule-id', 'test-location-id');
        $ruleApi->deleteRule('test-rule-id', 'test-location-id');
        $ruleApi->getOneById('test-rule-id', 'test-location-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteRuleMissingLocationId(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->deleteRule('test-rule-id', '');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testExecute(): void
    {
        $data = ['executionId' => 'test-execution-id', 'id' => 'test-rule-id', 'result' => 'Success'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(RuleApiInterface::API_URL_EXECUTE_SPRINTF, 'test-rule-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $result = self::createStub(RuleExecutionResultInterface::class);

        $ruleExecutionResultTransformer = self::createMock(RuleExecutionResultTransformerInterface::class);
        $ruleExecutionResultTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($result);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), $ruleExecutionResultTransformer, self::createStub(RuleRequestSerializerInterface::class));
        $actual = $ruleApi->execute('test-rule-id');

        self::assertSame($result, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testExecuteEncodesIdWithRealTransformer(): void
    {
        $data = ['executionId' => 'test-execution-id', 'id' => 'a/b c', 'result' => 'Success'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(RuleApiInterface::API_URL_EXECUTE_SPRINTF, rawurlencode('a/b c')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        // The real execution result transformer, so the parsed result is checked.
        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), new RuleExecutionResultTransformer(), self::createStub(RuleRequestSerializerInterface::class));
        $actual = $ruleApi->execute('a/b c');

        self::assertSame('test-execution-id', $actual->getExecutionId());
        self::assertSame('a/b c', $actual->getId());
        self::assertSame('Success', $actual->getResult());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            RuleApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                RuleApiInterface::API_URL,
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $rules = [self::createStub(RuleInterface::class), self::createStub(RuleInterface::class)];

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);

        $rulesTransformer = self::createMock(RulesTransformerInterface::class);
        $rulesTransformer->expects(self::once())->method('transform')
            ->with($data[RuleApiInterface::KEY_ITEMS])
            ->willReturn($rules);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));
        $actual = $ruleApi->getMultiple('test-location-id');

        self::assertSame($rules, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            RuleApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $rules = [self::createStub(RuleInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);

        $rulesTransformer = self::createMock(RulesTransformerInterface::class);
        $rulesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[RuleApiInterface::KEY_ITEMS])
            ->willReturn($rules);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        // Second call for the same locationId is served from the cache without hitting the API.
        self::assertSame($rules, $ruleApi->getMultiple('test-location-id'));
        self::assertSame($rules, $ruleApi->getMultiple('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleMissingLocationId(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->getMultiple('');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            RuleApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $rules = [self::createStub(RuleInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);

        $rulesTransformer = self::createMock(RulesTransformerInterface::class);
        $rulesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[RuleApiInterface::KEY_ITEMS])
            ->willReturn($rules);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($rules, $ruleApi->getMultiple('test-location-id'));
        self::assertSame($rules, $ruleApi->getMultiple('test-location-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[RuleApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[RuleApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RuleApiInterface::UNEXPECTED_RESPONSE_SPRINTF, RuleApiInterface::KEY_ITEMS));
        $ruleApi->getMultiple('test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-rule-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(RuleApiInterface::API_URL_SPRINTF, 'test-rule-id'),
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $rule = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));
        $actual = $ruleApi->getOneById('test-rule-id', 'test-location-id');

        self::assertSame($rule, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-rule-data'];

        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        // Second call for the same ruleId is served from the cache without hitting the API.
        self::assertSame($rule, $ruleApi->getOneById('test-rule-id', 'test-location-id'));
        self::assertSame($rule, $ruleApi->getOneById('test-rule-id', 'test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../rules'])]
    public function testGetOneByIdEncodesId(string $ruleId): void
    {
        $data = ['test-rule-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(RuleApiInterface::API_URL_SPRINTF, rawurlencode($ruleId)),
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $rule = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));
        $actual = $ruleApi->getOneById($ruleId, 'test-location-id');

        self::assertSame($rule, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdMissingLocationId(): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->getOneById('test-rule-id', '');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-rule-data'];

        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($rule, $ruleApi->getOneById('test-rule-id', 'test-location-id'));
        self::assertSame($rule, $ruleApi->getOneById('test-rule-id', 'test-location-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(RuleApiInterface::API_URL_SPRINTF, 'test-rule-id'),
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(RuleApiInterface::UNEXPECTED_RESPONSE);
        $ruleApi->getOneById('test-rule-id', 'test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRule(): void
    {
        $data = ['test-rule-data'];

        $request = new RuleRequest('Test Rule', [['test-action']]);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(RuleApiInterface::API_URL_SPRINTF, 'test-rule-id'),
                [RuleApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $ruleRequestSerializer = self::createMock(RuleRequestSerializerInterface::class);
        $ruleRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $rule = self::createStub(RuleInterface::class);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), $ruleRequestSerializer);
        $actual = $ruleApi->updateRule('test-rule-id', 'test-location-id', $request);

        self::assertSame($rule, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRuleMissingLocationId(): void
    {
        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(RuleApiInterface::MISSING_LOCATION_ID);
        $ruleApi->updateRule('test-rule-id', '', new RuleRequest('Test Rule', [['test-action']]));
    }

    /**
     * updateRule() refreshes the cached copy of this rule, so a subsequent
     * getOneById() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRulePopulatesCache(): void
    {
        $rule = self::createStub(RuleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn(['test-rule-data']);

        $ruleTransformer = self::createMock(RuleTransformerInterface::class);
        $ruleTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($rule);

        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        self::assertSame($rule, $ruleApi->updateRule('test-rule-id', 'test-location-id', new RuleRequest('Test Rule', [['test-action']])));
        self::assertSame($rule, $ruleApi->getOneById('test-rule-id', 'test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRuleUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $ruleTransformer = self::createStub(RuleTransformerInterface::class);
        $rulesTransformer = self::createStub(RulesTransformerInterface::class);

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'), self::createStub(RuleExecutionResultTransformerInterface::class), self::createStub(RuleRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(RuleApiInterface::UNEXPECTED_RESPONSE);
        $ruleApi->updateRule('test-rule-id', 'test-location-id', new RuleRequest('Test Rule', [['test-action']]));
    }
}
