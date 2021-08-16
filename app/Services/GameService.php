<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Game;

class GameService
{
    private const WINNING_COMBINATIONS = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6],
    ];
    private const X = 'X';
    private const ZERO = '0';
    private const EMPTY_CELL = '-';

    public function __construct(private Game $game)
    {
    }

    public function validateMove(int $position): bool
    {
        return $this->game->board[$position] === self::EMPTY_CELL;
    }

    public function makeMove(int $position) : Game
    {
        $this->game->makeMove($position, self::X);

        if ($this->isPlayerWon()) {
            $this->game->setStatusPlayerWon();
            return $this->game;
        }

        $listOfProbableMovement = $this->getListOfProbableMovements();
        if (count($listOfProbableMovement) === 0) {
            $this->game->setStatusDraw();
            return $this->game;
        }

        $this->computerMakeMove($listOfProbableMovement);

        if ($this->isComputerWon()) {
            $this->game->setStatusComputerWon();
            return $this->game;
        }

        $this->game->save();

        return $this->game;
    }

    private function isPlayerWon() : bool
    {
        return $this->checkWon(self::X);
    }

    private function isComputerWon() : bool
    {
        return $this->checkWon(self::ZERO);
    }

    private function computerMakeMove(array $listOfProbableMovement) : void
    {
        $this->game->makeMove(array_rand($listOfProbableMovement), self::ZERO);
    }

    private function checkWon(string $sign) : bool
    {
        foreach (self::WINNING_COMBINATIONS as $line) {
            if ($this->game->board[$line[0]] . $this->game->board[$line[1]] . $this->game->board[$line[2]]
                === "$sign$sign$sign") {
                return true;
            }
        }

        return false;
    }

    private function getListOfProbableMovements() : array
    {
        $list = [];
        for ($i = 0; $i < 9; $i++) {
            if ($this->validateMove($i)) {
                $list[] = $i;
            }
        }

        return $list;
    }
}
