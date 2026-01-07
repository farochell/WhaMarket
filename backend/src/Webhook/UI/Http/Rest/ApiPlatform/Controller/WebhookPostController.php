<?php

declare(strict_types=1);

namespace App\Webhook\UI\Http\Rest\ApiPlatform\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class WebhookPostController {

    public function __invoke(Request $request): Response {
        $fp = fopen('log.txt', 'a+');

        // Log du body brut
        fwrite($fp, "RAW BODY:\n".$request->getContent()."\n");

        // Essayer de décoder JSON
        $data = json_decode($request->getContent(), true);
        if ($data !== null) {
            fwrite($fp, "JSON DECODED:\n".json_encode($data, JSON_PRETTY_PRINT)."\n");
        } else {
            fwrite($fp, "JSON DECODE FAILED\n");
        }

        fclose($fp);
        return new Response('ok', 200);
    }
}
