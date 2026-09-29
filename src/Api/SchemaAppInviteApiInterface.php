<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptanceInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePageInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteReceiptInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteStatusInterface;

interface SchemaAppInviteApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/invites/schemaApp';
    public const string API_URL_ACCEPT_SPRINTF = 'https://api.smartthings.com/v1/invites/schemaApp/%s/accept';
    public const string API_URL_CHECK_ACCEPTANCE = 'https://api.smartthings.com/v1/invites/schemaApp/checkAcceptance';
    public const string KEY_INVITATION_ID = 'invitationId';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_PAGE = 'page';
    public const string KEY_SCHEMA_APP_ID = 'schemaAppId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Accepts a schema app invitation by its short code.
     */
    public function acceptInvite(string $shortCode): SchemaAppInviteAcceptanceInterface;

    /**
     * Reads whether an invitation has been accepted.
     */
    public function checkAcceptance(string $invitationId, bool $skipCache = false): SchemaAppInviteStatusInterface;

    /**
     * Creates an invitation to a schema app.
     */
    public function createInvite(SchemaAppInviteRequestInterface $request): SchemaAppInviteReceiptInterface;

    /**
     * Lists the invitations of a schema app, one page at a time.
     */
    public function getInvites(string $schemaAppId, ?int $limit = null, ?string $page = null, bool $skipCache = false): SchemaAppInvitePageInterface;
}
