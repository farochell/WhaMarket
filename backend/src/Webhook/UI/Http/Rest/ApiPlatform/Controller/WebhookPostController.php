<?php

declare(strict_types=1);

namespace App\Webhook\UI\Http\Rest\ApiPlatform\Controller;

use App\Conversation\Application\HandleIncomingMessage\HandleIncomingMessageCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\UI\Http\Rest\Exception\Formatter\ErrorFormatterTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Throwable;

#[AsController]
class WebhookPostController {

    use ErrorFormatterTrait;

    public function __construct(
        private readonly CommandBus $commandBus,
    ) {}

    public function __invoke(Request $request): Response {
       try {
           $payload = $this->getPayload($request);

           if (!$payload) {
               return new Response('Invalid JSON', Response::HTTP_BAD_REQUEST);
           }

           $messages = $this->extractMessages($payload);

           if (empty($messages)) {
               return new Response('No messages', Response::HTTP_OK);
           }

           foreach ($messages as $messageData) {
               $phoneNumber = $messageData['from'] ?? null;
               $text = $messageData['text']['body'] ?? null;
               $this->commandBus->dispatch(
                   new HandleIncomingMessageCommand(
                       $phoneNumber,
                       $text,
                       'whatsapp'
                   )
               );
           }

           return new Response('ok', 200);
       } catch (Throwable $exception) {
           $fp = fopen('error.txt', 'a+');
           fwrite($fp, $exception->getMessage());
           $this->formatError($exception);
       }
    }

    private function getPayload(Request $request): ?array
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $fp = fopen('loggerss.txt', 'a+');
        fwrite($fp, $content);
        return is_array($data) ? $data : null;
    }

    private function extractMessages(array $payload): array
    {
        $messages = [];

        $entries = $payload['entry'] ?? [];
        foreach ($entries as $entry) {
            $changes = $entry['changes'] ?? [];
            foreach ($changes as $change) {
                $value = $change['value'] ?? [];
                if (!empty($value['messages'])) {
                    foreach ($value['messages'] as $msg) {
                        $messages[] = $msg;
                    }
                }
            }
        }

        return $messages;
    }
}
