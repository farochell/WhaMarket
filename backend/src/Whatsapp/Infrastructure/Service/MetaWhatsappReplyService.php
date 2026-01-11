<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Whatsapp\Infrastructure\Service;

use App\Conversation\Domain\Entity\SellerConversation;
use App\User\Domain\ValueObject\PhoneNumber;
use App\Whatsapp\Domain\Service\WhatsappReplyService;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class MetaWhatsappReplyService implements WhatsappReplyService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        private readonly string $phoneNumberId,
        private readonly string $accessToken,
        private readonly string $apiVersion,
    ) {}

    public function reply(SellerConversation $conversation): void {
        // TODO: Implement reply() method.
    }

    public function sendText(PhoneNumber $phoneNumber, string $message): void {
        $url = sprintf(
            'https://graph.facebook.com/%s/%s/messages',
            "v24.0",
            $this->phoneNumberId
        );

        $payload = [
            'messaging_product' => 'whatsapp',
            "recipient_type" => "individual",
            'to' => ltrim($phoneNumber->toString(), '+'),
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        $this->logger->info('WhatsApp API request', [
            'url' => $url,
            'payload' => $payload,
        ]);

        $response = $this->httpClient->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => $payload,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent(false);

        $this->logger->info('WhatsApp API response', [
            'status_code' => $statusCode,
            'content' => $content,
        ]);

        if ($statusCode >= 400) {
            throw new \RuntimeException(sprintf(
                'WhatsApp API error (%d): %s',
                $statusCode,
                $content
            ));
        }
    }
}
