<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Webhook\UI\Http\Rest\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Webhook\UI\Http\Rest\ApiPlatform\Controller\WebhookGetController;
use App\Webhook\UI\Http\Rest\ApiPlatform\Controller\WebhookPostController;


#[ApiResource(
    operations:[
        new Post(
            uriTemplate: '/webhook',
            controller: WebhookPostController::class
        ),
        new Get(
            uriTemplate: '/webhook',
            controller: WebhookGetController::class
        )
    ]
)]
class WebhookResource {}
