<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\Shop\Domain\ValueObject;

enum ShopCategory: string
{
    case FOOD = 'FOOD';
    case CLOTHING = 'CLOTHING';
    case OTHER = 'OTHER';
}
