<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class OrganizationApi implements OrganizationApiInterface
{
    /**
     * @var array<string, OrganizationInterface>
     */
    private array $cache = [];

    /**
     * @var ?array<int, OrganizationInterface>
     */
    private ?array $listCache = null;
    private OrganizationsTransformerInterface $organizationsTransformer;
    private OrganizationTransformerInterface $organizationTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, OrganizationTransformerInterface $organizationTransformer, OrganizationsTransformerInterface $organizationsTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->organizationTransformer = $organizationTransformer;
        $this->organizationsTransformer = $organizationsTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, OrganizationInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $organizations = $this->organizationsTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache = $organizations;

        return $organizations;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $organizationId, bool $skipCache = false): OrganizationInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$organizationId])) {
                return $this->cache[$organizationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($organizationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $organization = $this->organizationTransformer->transform($data);
        $this->cache[$organizationId] = $organization;

        return $organization;
    }
}
