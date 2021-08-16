<?php

namespace App\Http\Controllers;

use App\ {
    Http\Requests\MoveRequest,
    Models\Game,
    Services\GameService
};
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse(Game::all());
    }

    public function create(): JsonResponse
    {
        return new JsonResponse(Game::createEmptyGame());
    }

    public function show(Game $game): JsonResponse
    {
        return new JsonResponse($game);
    }

    public function move(Game $game, MoveRequest $request): JsonResponse
    {
        $service = new GameService($game);

        if (!$service->validateMove($request->get('position'))) {
            return new JsonResponse('Wrong position', 400);
        }

        return new JsonResponse($service->makeMove($request->get('position')));
    }

    public function delete(Game $game): JsonResponse
    {
        $game->delete();
        return new JsonResponse();
    }
}
