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
use ChristianBrown\SmartThings\Model\RuleInterface;
use ChristianBrown\SmartThings\Transformer\RulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(RuleApi::class)]
#[CoversClass(Token::class)]
final class RuleApiTest extends TestCase
{
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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));
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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));
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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));
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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

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

        $ruleApi = new RuleApi($requestSender, $ruleTransformer, $rulesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(RuleApiInterface::UNEXPECTED_RESPONSE);
        $ruleApi->getOneById('test-rule-id', 'test-location-id', $skipCache);
    }
}
