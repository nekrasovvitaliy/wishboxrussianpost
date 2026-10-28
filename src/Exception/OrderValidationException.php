<?php

declare(strict_types=1);

namespace WishboxRussianPost\Exception;

use WishboxRussianPost\Exception\RussianPostException;

final class OrderValidationException extends RussianPostException
{
    /**
     * @param list<string> $errors
     */
    public function __construct(
        private readonly array $errors,
    ) {
        parent::__construct($errors === [] ? 'Order request validation failed.' : implode('; ', $errors));
    }

    /**
     * @return list<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
