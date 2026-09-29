<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptanceInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePageInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteReceiptInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteStatusInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppInviteRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformerInterface;

use function array_filter;
use function rawurlencode;
use function sprintf;

final class SchemaAppInviteApi implements SchemaAppInviteApiInterface
{
    private JsonApiRequestSenderInterface $requestSender;
    private SchemaAppInviteAcceptanceTransformerInterface $schemaAppInviteAcceptanceTransformer;
    private SchemaAppInvitePageTransformerInterface $schemaAppInvitePageTransformer;
    private SchemaAppInviteReceiptTransformerInterface $schemaAppInviteReceiptTransformer;
    private SchemaAppInviteRequestSerializerInterface $schemaAppInviteRequestSerializer;
    private SchemaAppInviteStatusTransformerInterface $schemaAppInviteStatusTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, TokenInterface $token, SchemaAppInviteRequestSerializerInterface $schemaAppInviteRequestSerializer, SchemaAppInviteReceiptTransformerInterface $schemaAppInviteReceiptTransformer, SchemaAppInviteAcceptanceTransformerInterface $schemaAppInviteAcceptanceTransformer, SchemaAppInvitePageTransformerInterface $schemaAppInvitePageTransformer, SchemaAppInviteStatusTransformerInterface $schemaAppInviteStatusTransformer)
    {
        $this->requestSender = $requestSender;
        $this->token = $token;
        $this->schemaAppInviteRequestSerializer = $schemaAppInviteRequestSerializer;
        $this->schemaAppInviteReceiptTransformer = $schemaAppInviteReceiptTransformer;
        $this->schemaAppInviteAcceptanceTransformer = $schemaAppInviteAcceptanceTransformer;
        $this->schemaAppInvitePageTransformer = $schemaAppInvitePageTransformer;
        $this->schemaAppInviteStatusTransformer = $schemaAppInviteStatusTransformer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function acceptInvite(string $shortCode): SchemaAppInviteAcceptanceInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_ACCEPT_SPRINTF, rawurlencode($shortCode));
        $data = $this->requestSender->put($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppInviteAcceptanceTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function checkAcceptance(string $invitationId, bool $skipCache = false): SchemaAppInviteStatusInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $query = array_filter([self::KEY_INVITATION_ID => $invitationId], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL_CHECK_ACCEPTANCE, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppInviteStatusTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function createInvite(SchemaAppInviteRequestInterface $request): SchemaAppInviteReceiptInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->schemaAppInviteRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppInviteReceiptTransformer->transform($data);

        return $result;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getInvites(string $schemaAppId, ?int $limit = null, ?string $page = null, bool $skipCache = false): SchemaAppInvitePageInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $query = array_filter([self::KEY_SCHEMA_APP_ID => $schemaAppId, self::KEY_LIMIT => self::formatInt($limit), self::KEY_PAGE => $page], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $result = $this->schemaAppInvitePageTransformer->transform($data);

        return $result;
    }

    private static function formatInt(?int $value): ?string
    {
        return null === $value ? null : (string) $value;
    }
}
