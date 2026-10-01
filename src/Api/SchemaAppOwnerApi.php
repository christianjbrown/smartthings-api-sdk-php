<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationSchemaAppsInterface;
use ChristianBrown\SmartThings\Model\UserSchemaAppsInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\UserSchemaAppsTransformerInterface;

use function array_filter;
use function rawurlencode;
use function sprintf;

final class SchemaAppOwnerApi implements SchemaAppOwnerApiInterface
{
    /**
     * @var array<string, OrganizationSchemaAppsInterface>
     */
    private array $organizationCache = [];
    private OrganizationSchemaAppsTransformerInterface $organizationSchemaAppsTransformer;
    private JsonReadApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, UserSchemaAppsInterface>
     */
    private array $userCache = [];
    private UserSchemaAppsTransformerInterface $userSchemaAppsTransformer;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, OrganizationSchemaAppsTransformerInterface $organizationSchemaAppsTransformer, UserSchemaAppsTransformerInterface $userSchemaAppsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->organizationSchemaAppsTransformer = $organizationSchemaAppsTransformer;
        $this->userSchemaAppsTransformer = $userSchemaAppsTransformer;
        $this->token = $token;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOrganizationApps(?string $organizationId = null, bool $skipCache = false): OrganizationSchemaAppsInterface
    {
        // Casting keeps a missing organization and a real id as distinct string keys.
        $cacheKey = (string) $organizationId;
        if (!$skipCache) {
            if (isset($this->organizationCache[$cacheKey])) {
                return $this->organizationCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ] + array_filter([self::HEADER_KEY_ORGANIZATION_ID => $organizationId], static fn (?string $value): bool => null !== $value);
        $data = $this->requestSender->get(self::API_URL_ORGANIZATION_APPS, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $apps = $this->organizationSchemaAppsTransformer->transform($data);
        $this->organizationCache[$cacheKey] = $apps;

        return $apps;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getUserApps(string $userId, bool $skipCache = false): UserSchemaAppsInterface
    {
        if (!$skipCache) {
            if (isset($this->userCache[$userId])) {
                return $this->userCache[$userId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(sprintf(self::API_URL_USER_APPS_SPRINTF, rawurlencode($userId)), [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $apps = $this->userSchemaAppsTransformer->transform($data);
        $this->userCache[$userId] = $apps;

        return $apps;
    }
}
