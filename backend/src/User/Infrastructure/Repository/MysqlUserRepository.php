<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\Shared\Domain\Exception\EntityPersistenceException;
use App\Shared\Infrastructure\Repository\BaseRepository;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Infrastructure\Doctrine\Mapping\UserDoctrine;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Throwable;

class MysqlUserRepository extends BaseRepository implements UserRepository
{
    public function __construct(
        ManagerRegistry $managerRegistry,
        LoggerInterface $logger
    ) {
        parent::__construct(
            $managerRegistry,
            UserDoctrine::class,
            'User',
            $logger
        );
    }

    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?User {
        $user = $this->getEntityManager()
            ->getRepository(UserDoctrine::class)
            ->findOneBy(['phoneNumber' => $phoneNumber]);

        if ($user === null) {
            $this->logAndThrowNotFoundException($phoneNumber->value());
            return null;
        }
        return $this->transformEntity($user);
    }

    public function save(User $user): void {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        } catch (Throwable $e) {
            $exception = EntityPersistenceException::fromPrevious(
                $this->entityName,
                $e
            );
            $this->logAndThrowException(
                $exception,
                $user,
                [  'action' => 'save',  'data' => $this->serializeEntity($user)]
            );
        }
    }

    public function update(User $user): void {
        try {
            $this->getEntityManager()->flush();
        } catch (Throwable $e) {
            $exception = EntityPersistenceException::fromPrevious($this->entityName, $e);
            $this->logAndThrowException(
                $exception,
                $user,
                [  'action' => 'update',  'data' => $this->serializeEntity($user)]
            );
        }
    }

    private function transformEntity(UserDoctrine $user): User {
        return new User(
            $user->id,
            $user->phoneNumber,
            $user->hashedPassword,
            $user->roles,
            $user->fullName,
            $user->isActive,
            $user->email
        );
    }
}
