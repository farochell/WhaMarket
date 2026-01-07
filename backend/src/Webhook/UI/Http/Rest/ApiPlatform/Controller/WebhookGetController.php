<?php

declare(strict_types=1);

namespace App\Webhook\UI\Http\Rest\ApiPlatform\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class WebhookGetController {

    public function __invoke(Request $request): Response {
        $query = $request->query->all();
        $mode = $query['hub_mode'] ?? null;
        $challenge = $query['hub_challenge'] ?? null;
        $token = $query['hub_verify_token'] ?? null;
        return new Response($challenge, 200);
    }
}
