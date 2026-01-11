<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Application\HandleIncomingMessage;

use App\Conversation\Application\Handler\MessageRouter;
use App\Conversation\Domain\Entity\SellerConversation;
use App\Conversation\Domain\Repository\SellerConversationRepository;
use App\Conversation\Domain\ValueObject\Channel;
use App\Conversation\Domain\ValueObject\ConversationState;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Bus\Command\CommandResponse;
use App\Shared\Domain\Bus\Command\EmptyCommandResponse;
use App\User\Domain\ValueObject\PhoneNumber;
use App\Whatsapp\Domain\Service\WhatsappReplyService;

class HandleIncomingMessageCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly SellerConversationRepository $conversationRepository,
        private readonly MessageRouter $messageRouter,
        private readonly WhatsappReplyService $whatsappReplyService,
    ) {}

    public function __invoke(HandleIncomingMessageCommand $command): CommandResponse
    {
        $phoneNumber = PhoneNumber::fromString($command->phoneNumber);

        $conversation = $this->conversationRepository->findByPhoneNumber($phoneNumber);

        if (null === $conversation) {
            if (!$this->isStartKeyword($command->message)) {
                $this->whatsappReplyService->sendText(
                    $phoneNumber,
                    "Pour commencer, envoyez le mot INSCRIPTION"
                );
                return new EmptyCommandResponse();
            }

            $conversation = SellerConversation::create(
                PhoneNumber::fromString($command->phoneNumber),
                Channel::from($command->channel),
                ConversationState::INSCRIPTION_START
            );
        }

        $updatedConversation = $this->messageRouter->route($conversation, $command->message);

        if (!$updatedConversation->equals($conversation)) {
            $this->conversationRepository->save($updatedConversation);
        }


        $this->whatsappReplyService->reply($updatedConversation);
        return new EmptyCommandResponse();
    }

    private function isStartKeyword(string $message): bool
    {
        return in_array(
            mb_strtolower(trim($message)),
            ['inscription', 'inscrire', 'register'],
            true
        );
    }
}
