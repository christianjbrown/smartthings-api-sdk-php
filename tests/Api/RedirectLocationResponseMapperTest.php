<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\ApiRequestSender;
use ChristianBrown\ApiClient\JsonApiRequestSender;
use ChristianBrown\ApiClient\Transformer\ArrayToJsonTransformer;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformer;
use ChristianBrown\SmartThings\Api\RedirectLocationResponseMapper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RedirectLocationResponseMapper::class)]
final class RedirectLocationResponseMapperTest extends TestCase
{
    public function testLeavesOtherResponsesAlone(): void
    {
        $original = new Response(200, [], '{"a":1}');

        self::assertSame($original, (new RedirectLocationResponseMapper())($original));
    }

    public function testLetsTheJsonRequestSenderReadARedirectWithoutFollowingIt(): void
    {
        $stack = HandlerStack::create(new MockHandler([new Response(302, ['Location' => 'https://weather.example/alert'])]));
        $stack->push(Middleware::mapResponse(new RedirectLocationResponseMapper()));
        $client = new Client(['handler' => $stack, 'allow_redirects' => false]);
        $sender = new JsonApiRequestSender(new ApiRequestSender($client), new JsonToArrayTransformer(), new ArrayToJsonTransformer());

        self::assertSame(['location' => 'https://weather.example/alert'], $sender->get('https://api.smartthings.com/v1/alert'));
    }

    public function testTurnsALocationHeaderIntoAJsonBody(): void
    {
        $response = (new RedirectLocationResponseMapper())(new Response(302, ['Location' => 'https://weather.example/alert']));

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('{"location":"https:\/\/weather.example\/alert"}', (string) $response->getBody());
    }
}
