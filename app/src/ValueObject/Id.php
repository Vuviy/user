<?php

namespace App\ValueObject;

use InvalidArgumentException;
final class Id
{
    /** @var string */
    private string $value;

    /**
     * Id constructor
     *
     * @param string $id
     * @throws InvalidArgumentException
     */
    public function __construct(string $id)
    {
        $id = trim($id);

        if (!$this->isValidUuid($id)) {
            throw new InvalidArgumentException("Invalid UUID: {$id}");
        }

        $this->value = $id;
    }

    /**
     * check valid for uuid
     *
     * @param string $uuid
     * @return bool
     */
    private function isValidUuid(string $uuid): bool
    {
        return preg_match(
                '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
                $uuid
            ) === 1;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}