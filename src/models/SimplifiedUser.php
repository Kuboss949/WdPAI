<?php

class SimplifiedUser
{
    private int $id;
    private string $login;
    private string $email;
    private bool $enabled;
    private string $role;

    /**
     * @param int $id
     * @param string $login
     * @param string $email
     * @param bool $enabled
     * @param string $role
     */
    public function __construct(int $id, string $login, string $email, bool $enabled, string $role)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->enabled = $enabled;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getRole(): string
    {
        return $this->role;
    }


}