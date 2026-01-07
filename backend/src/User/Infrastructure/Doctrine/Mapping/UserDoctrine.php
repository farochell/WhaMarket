<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Mapping;

use App\Authentication\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\PhoneNumber;
use App\User\Domain\ValueObject\Roles;
use App\User\Domain\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class UserDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'user_id', unique: true)]
    public UserId $id;

    #[ORM\Column(type: 'phone_number', length: 20)]
    public PhoneNumber $phoneNumber;

    #[ORM\Column(type: 'roles')]
    public Roles $roles;

    #[ORM\Column(type: 'hashed_password', length: 255)]
    public HashedPassword $hashedPassword;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    public string $fullName;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    public ?string $email;

    #[ORM\Column(type: 'boolean')]
    public bool $isActive = true;
}
