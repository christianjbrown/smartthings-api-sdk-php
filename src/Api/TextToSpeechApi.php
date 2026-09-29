<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ConvertedTtsInterface;
use ChristianBrown\SmartThings\Model\PlayedTextInterface;
use ChristianBrown\SmartThings\Model\PlayTextRequestInterface;
use ChristianBrown\SmartThings\Model\TtsInfoInterface;
use ChristianBrown\SmartThings\Model\TtsRequestInterface;
use ChristianBrown\SmartThings\Serializer\PlayTextRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TtsRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformerInterface;

final class TextToSpeechApi implements TextToSpeechApiInterface
{
    private ConvertedTtsTransformerInterface $convertedTtsTransformer;

    /**
     * @var array<string, TtsInfoInterface>
     */
    private array $infoCache = [];
    private PlayedTextTransformerInterface $playedTextTransformer;
    private PlayTextRequestSerializerInterface $playTextRequestSerializer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;
    private TtsInfoTransformerInterface $ttsInfoTransformer;
    private TtsRequestSerializerInterface $ttsRequestSerializer;

    public function __construct(JsonApiRequestSenderInterface $requestSender, TokenInterface $token, TtsInfoTransformerInterface $ttsInfoTransformer, TtsRequestSerializerInterface $ttsRequestSerializer, ConvertedTtsTransformerInterface $convertedTtsTransformer, PlayTextRequestSerializerInterface $playTextRequestSerializer, PlayedTextTransformerInterface $playedTextTransformer)
    {
        $this->requestSender = $requestSender;
        $this->token = $token;
        $this->ttsInfoTransformer = $ttsInfoTransformer;
        $this->ttsRequestSerializer = $ttsRequestSerializer;
        $this->convertedTtsTransformer = $convertedTtsTransformer;
        $this->playTextRequestSerializer = $playTextRequestSerializer;
        $this->playedTextTransformer = $playedTextTransformer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function convert(TtsRequestInterface $request): ConvertedTtsInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->ttsRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->convertedTtsTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInfo(bool $skipCache = false): TtsInfoInterface
    {
        $cacheKey = 'info';
        if (!$skipCache) {
            if (isset($this->infoCache[$cacheKey])) {
                return $this->infoCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL_INFO, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->ttsInfoTransformer->transform($data);
        $this->infoCache[$cacheKey] = $result;

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function playText(PlayTextRequestInterface $request): PlayedTextInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->playTextRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL_PLAYTEXT, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->playedTextTransformer->transform($data);

        return $result;
    }
}
