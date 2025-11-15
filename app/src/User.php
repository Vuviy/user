<?php

namespace App;
use App\ValueObject\Email;
use App\ValueObject\Id;
use App\ValueObject\Password;
use App\ValueObject\Role;
use DateTimeImmutable;
use InvalidArgumentException;

class User
{
    private Id $id;
    private Email $email;
    private Password $password;
    private Role $role;
    private DateTimeImmutable $created_at;


    /**
     * User constructor.
     *
     * @param Id $id
     * @param Email $email
     * @param Password $password  // making by fromPlain() or fromHash)
     * @param Role $role
     * @param DateTimeImmutable|null $createdAt
     */
    public function __construct(
        Id $id,
        Email $email,
        Password $password,
        Role $role,
        ?DateTimeImmutable $createdAt = null
    ){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->created_at = $createdAt ?? new DateTimeImmutable();
    }


    public function setId(Id $id)
    {
        $this->id = $id;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setPassword(Password $password)
    {
        $this->password = $password;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setRole(Role $role)
    {
        $this->role = $role;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param Email|null $email
     * @param Role|null $role
     * @param Password|null $password
     * @return void
     */
    public function updateProfile(
        ?Email $email = null,
        ?Role $role = null,
        ?Password $password = null
    ): void {
        if ($email !== null) {
            $this->email = $email;
        }

        if ($role !== null) {
            $this->role = $role;
        }

        if ($password !== null) {
            $this->password = $password;
        }
    }

    /**
     * check role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role->is($role);
    }

    public function __get(string $name)
    {
        $name = strtolower(trim($name));

        if (!property_exists($this, $name)) {
            throw new InvalidArgumentException("Property '{$name}' does not exist on User");
        }

        return $this->$name;
    }

    public function __set(string $name, $value): void
    {
        $name = strtolower(trim($name));

        if (!property_exists($this, $name)) {
            throw new InvalidArgumentException("Property '{$name}' does not exist on User");
        }

        if($name === 'password') {
            throw new InvalidArgumentException("You cannot set password for user in this method");
        }

        $class = sprintf('%s%s', 'App\ValueObject\\', ucfirst($name));

        $this->$name = new $class($value);
    }

    public function __toString(): string
    {
        return self::class;
    }


    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [
          'id' => (string)$this->id,
          'email' => (string)$this->email,
          'password' => $this->password->getHash(),
          'role' => (string)$this->role,
          'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     *
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->id = new Id($data['id']);
        $this->email = new Email($data['email']);
        $this->password = Password::fromHash($data['password']);
        $this->role = new Role($data['role']);
        $this->created_at = new DateTimeImmutable($data['created_at']);
    }

    public function toArray(): array
    {
        return [
          'id' => (string)$this->id,
          'email' => (string)$this->email,
          'password' => $this->password->getHash(),
          'role' => (string)$this->role,
          'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}