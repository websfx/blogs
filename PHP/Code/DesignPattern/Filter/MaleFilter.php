<?php

namespace App\Filter;

class MaleFilter implements Filter
{
    public function filter(array $users): array
    {
        $result = [];

        foreach ($users as $user) {
            if ($user->getGender() == '男') {
                $result[] = $user;
            }
        }

        return $result;
    }
}
