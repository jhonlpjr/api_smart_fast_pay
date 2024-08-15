<?php

namespace app\modules\user\domain\entities;

class User
{
    public int $id;
    public string $username;
    public string $email;
    public string $names;
    public string $lastnames;
    public string $identity_document;
    public float $balance;
    public string $password;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(Array $userData)
    {
        if(isset($userData['id'])) $this->id = $userData['id'];
        $this->username = $userData['username'] ?? '';
        $this->email = $userData['email'] ?? '';
        $this->names = $userData['names'] ??'';
        $this->lastnames = $userData['lastnames'] ?? '';
        $this->identity_document = $userData['identity_document'] ?? '';
        $this->balance = $userData[''] ?? 0;
        $this->password = $userData['password'] ?? '';
        $this->created_at = $userData['created_at'] ?? null;
        $this->updated_at = $userData['updated_at'] ?? null;
        $this->deleted_at = $userData['deleted_at'] ?? null;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
