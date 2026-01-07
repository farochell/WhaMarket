<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Authentication\Infrastructure\Service;

use App\Authentication\Domain\Service\AccessTokenDecoder;
use App\Authentication\Domain\ValueObject\AccessToken;

/**
 * Stub implementation of AccessTokenDecoder for development purposes.
 * WARNING: This does NOT validate tokens. Replace with proper JWT implementation for production.
 */
readonly class StubAccessTokenDecoder implements AccessTokenDecoder
{
    public function decode(string $token): AccessToken
    {
        // WARNING: This is a stub implementation that does NOT validate tokens
        // Replace with proper JWT decoding for production use

        return new AccessToken(
            content: $token,
            id: 1,
            username: 'dev-user',
            roles: ['ROLE_USER'],
            createdAt: time(),
            expiresAt: time() + 3600,
        );
    }
}
