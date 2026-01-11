<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Conversation\Domain\ValueObject;

enum ConversationState: string
{
    case INSCRIPTION_START = 'INSCRIPTION_START';
    case INSCRIPTION_CONFIRM = 'INSCRIPTION_CONFIRM';
    case WAITING_SHOP_NAME = 'WAITING_SHOP_NAME';
    case WAITING_SHOP_CATEGORY = 'WAITING_SHOP_CATEGORY';
    case WAITING_SHOP_CITY = 'WAITING_SHOP_CITY';
    case INSCRIPTION_DONE = 'INSCRIPTION_DONE';
    case SHOP_MENU = 'SHOP_MENU';
}
