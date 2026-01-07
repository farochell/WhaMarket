<?php

/**
 * @author Emile Camara <camara.emile@gmail.com>
 *
 * @project  wha-market
 */

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

trait ApiExceptionTrait
{
    /**
     * @return mixed[]
     */
    public function toOpenApiError(): array
    {
        return [
            'code' => $this->getErrorCode()->value,
            'message' => $this->getMessage(),
            'details' => $this->getDetails(),
        ];
    }
}
