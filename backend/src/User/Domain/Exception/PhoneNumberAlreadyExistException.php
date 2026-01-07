<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  wha-market
 */
declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\ApiExceptionInterface;
use App\Shared\Domain\Exception\ApiExceptionTrait;
use App\Shared\Domain\Exception\ErrorCode;
use DomainException;

class PhoneNumberAlreadyExistException extends DomainException implements ApiExceptionInterface {
    use ApiExceptionTrait;

    public function __construct(private readonly string $phoneNumber) {
        parent::__construct(
            message: 'Phone number already exists',
            code: 409
        );
    }

    public function getErrorCode(): ErrorCode {
        return ErrorCode::PHONE_NUMBER_ALREADY_EXISTS;
    }

    public function getDetails(): array {
        return [
            'phoneNumber' => $this->phoneNumber
        ];
    }
}
