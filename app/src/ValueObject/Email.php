<?php

namespace App\ValueObject;

use InvalidArgumentException;

final class Email
{
    /** @var string */
    private string $value;

    /**
     * Email constructor.
     *
     * @param string $email
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        $email = trim($email);

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email: {$email}");
        }

        $this->value = $email;
    }

    /**
     * return email as string.
     */
    public function __toString(): string
    {
        return $this->value;
    }
}