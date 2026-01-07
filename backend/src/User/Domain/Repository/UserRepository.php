<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\ValueObject\PhoneNumber;

interface UserRepository
{
    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?User;
    public function save(User $user): void;
    public function update(User $user): void;
}
