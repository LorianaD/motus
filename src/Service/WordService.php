<?php

namespace App\Service;

use App\Entity\Game;

class WordService
{
    public function wordCheck(string $guess, string $secret): array
    {
        $guess = strtoupper($guess);
        $secret = strtoupper($secret);

        $data = $this->markCorrectLetters($guess, $secret);

        return $this->markPresentLetters($guess, $secret, $data);
    }

    private function markCorrectLetters(string $guess, string $secret) : array
    {
        $result = [];
        $usedSecretLetters = [];

        for ($i = 0; $i < strlen($secret); $i++) {
            if ($guess[$i] === $secret[$i]) {
                $result[] = [
                    'letter' => $guess[$i],
                    'status' => 'correct',
                ];

                $usedSecretLetters[$i] = true;
            } else {
                $result[] = [
                    'letter' => $guess[$i],
                    'status' => 'absent',
                ];
            }
        }

        return [
            'result' => $result,
            'usedSecretLetters' => $usedSecretLetters,
        ];
    }

    public function getAttemptResults(Game $game) : array
    {
        $result = [];

        foreach ($game->getAttempts() as $attempt) {
            $result[] = $this->wordCheck(
                $attempt->getProposedWord(),
                $game->getWord()->getWord()
            );
        }
        
        return $result;
    }

    private function markPresentLetters(string $guess, string $secret, array $data) : array
    {
        $result = $data['result'];
        $usedSecretLetters = $data['usedSecretLetters'];

        for ($i=0; $i < strlen($secret); $i++) { 
            if ($result[$i]['status'] === 'correct') {
                continue;
            }

            for ($j=0; $j < strlen($secret); $j++) { 
                if (empty($usedSecretLetters[$j]) && $guess[$i] === $secret[$j]) {
                    $result[$i]['status'] = 'present';
                    $usedSecretLetters[$j] = true;
                    break;
                }
            }
        }

        return $result;        
    }
}