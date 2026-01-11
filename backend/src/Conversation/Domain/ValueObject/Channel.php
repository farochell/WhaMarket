<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Domain\ValueObject;

enum Channel: string
{
    case WHATSAPP = 'whatsapp';
    case EMAIL = 'email';
    case SMS = 'sms';
}
