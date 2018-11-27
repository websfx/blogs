<?php

namespace App\Filter;

class AgeFilter implements Filter
{
    public function filter(array $users): array
    {
        $result = [];

        foreach ($users as $user) {
            if ($user->getAge() > 25) {
                $result[] = $user;
            }
        }

        return $result;
    }
}
