<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ {
    Factories\HasFactory,
    Model
};

class Game extends Model
{
    use HasFactory;

    const STATUS_DRAW = 'DRAW';
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_X_WON = 'X_WON';
    const STATUS_O_WON = 'O_WON';
    const EMPTY_BOARD = '---------';

    public static function createEmptyGame(): self
    {
        $game = new self();
        $game->board = self::EMPTY_BOARD;
        $game->status = self::STATUS_RUNNING;
        $game->save();
        return $game;
    }

    public function makeMove(int $position, string $sign): void
    {
        $board = $this->board;
        $board[$position] = $sign;
        $this->board = $board;
    }

    public function setStatusDraw(): void
    {
        $this->status = self::STATUS_DRAW;
        $this->save();
    }

    public function setStatusPlayerWon(): void
    {
        $this->status = self::STATUS_X_WON;
        $this->save();
    }

    public function setStatusComputerWon(): void
    {
        $this->status = self::STATUS_O_WON;
        $this->save();
    }
}
