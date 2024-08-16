<?php

namespace app\modules\user\domain\entities; 

class UserBalance
{
    public int $userId;
    public string $userNames;
    public float $userBalance;
    public ?string $updateDate;

    public function __construct(Array $userData)
    {
        if(isset($userData['id'])) $this->userId = $userData['id'];
        if(isset($userData['names'])) $this->userNames = $userData['names'].' '.($userData['lastnames']??'');
        $this->userBalance = $userData['balance'] ?? 0;
        $this->updateDate = $userData['updated_at'] ?? null;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
