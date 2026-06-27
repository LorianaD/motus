<?php

namespace App\Service;

class WordService
{
    public function wordCheck(string $guess, string $secret): array
    {
        $guess = strtoupper($guess);
        $secret = strtoupper($secret);

        $result = [];

        for ($i = 0; $i < strlen($secret); $i++) {
            if ($guess[$i] === $secret[$i]) {
                $result[] = [
                    'letter' => $guess[$i],
                    'status' => 'correct',
                ];
            } elseif (str_contains($secret, $guess[$i])) {
                $result[] = [
                    'letter' => $guess[$i],
                    'status' => 'present',
                ];
            } else {
                $result[] = [
                    'letter' => $guess[$i],
                    'status' => 'absent',
                ];
            }
        }

        return $result;
    }
}