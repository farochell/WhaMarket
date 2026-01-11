<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Infrastructure\Repository;

use App\Conversation\Domain\Entity\SellerConversation;
use App\Conversation\Domain\Repository\SellerConversationRepository;
use App\Conversation\Infrastructure\Doctrine\Mapping\SellerConversationDoctrine;
use App\Shared\Infrastructure\Repository\BaseRepository;
use App\User\Domain\ValueObject\PhoneNumber;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class MysqlSellerConversation extends BaseRepository implements SellerConversationRepository {

    public function __construct(
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger
    ) {
        parent::__construct(
            $managerRegistry,
            SellerConversationDoctrine::class,
            'SellerConversation',
            $logger
        );
    }
    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?SellerConversation {
        $conversation = $this->getEntityManager()
            ->getRepository(SellerConversationDoctrine::class)
            ->findOneBy(['phoneNumber' => $phoneNumber]);

        if ($conversation === null) {
            $this->logAndThrowNotFoundException($phoneNumber->value());
            return null;
        }
        return $this->fromEntity($conversation);
    }

    public function save(SellerConversation $sellerConversation): void {
        // TODO: Implement save() method.
    }

    private function fromEntity(SellerConversationDoctrine $sellerConversationDoctrine): SellerConversation
    {
        return new SellerConversation();
    }
}
