<?php

namespace App\Filter;

class RegisterFilter implements Filter
{
    public function filter(array $users): array
    {
        $result = [];

        foreach ($users as $user) {
            if ($user->getRegisterAt() > 90*24*3600) {
                $result[] = $user;
            }
        }

        return $result;
    }
}
