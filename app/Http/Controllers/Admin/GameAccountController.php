<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGameAccountRequest;
use App\Http\Requests\StoreGameAccountRequest;
use App\Http\Requests\UpdateGameAccountRequest;
use App\Models\GameAccount;
use App\Models\Game;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GameAccountController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('game_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gameAccounts = GameAccount::all();
        $games = Game::getGameName();

        return view('admin.gameAccounts.index', compact('gameAccounts','games'));
    }

    public function create()
    {
        abort_if(Gate::denies('game_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameAccounts.create');
    }

    public function store(StoreGameAccountRequest $request)
    {
        $gameAccount = GameAccount::create($request->all());

        return redirect()->route('admin.game-accounts.index');
    }

    public function edit(GameAccount $gameAccount)
    {
        abort_if(Gate::denies('game_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameAccounts.edit', compact('gameAccount'));
    }

    public function update(UpdateGameAccountRequest $request, GameAccount $gameAccount)
    {
        $gameAccount->update($request->all());

        return redirect()->route('admin.game-accounts.index');
    }

    public function show(GameAccount $gameAccount)
    {
        abort_if(Gate::denies('game_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameAccounts.show', compact('gameAccount'));
    }

    public function destroy(GameAccount $gameAccount)
    {
        abort_if(Gate::denies('game_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gameAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroyGameAccountRequest $request)
    {
        GameAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
