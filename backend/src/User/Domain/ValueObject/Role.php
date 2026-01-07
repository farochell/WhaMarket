<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\ValueObject;

enum Role: string
{
    case ADMIN = 'ROLE_ADMIN';
    case MERCHANT = 'ROLE_MERCHANT';
}
