<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGameTransferRequest;
use App\Http\Requests\StoreGameTransferRequest;
use App\Http\Requests\UpdateGameTransferRequest;
use App\Models\GameTransfer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GameTransferController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('game_transfer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gameTransfers = GameTransfer::all();

        return view('admin.gameTransfers.index', compact('gameTransfers'));
    }

    public function create()
    {
        abort_if(Gate::denies('game_transfer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameTransfers.create');
    }

    public function store(StoreGameTransferRequest $request)
    {
        $gameTransfer = GameTransfer::create($request->all());

        return redirect()->route('admin.game-transfers.index');
    }

    public function edit(GameTransfer $gameTransfer)
    {
        abort_if(Gate::denies('game_transfer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameTransfers.edit', compact('gameTransfer'));
    }

    public function update(UpdateGameTransferRequest $request, GameTransfer $gameTransfer)
    {
        $gameTransfer->update($request->all());

        return redirect()->route('admin.game-transfers.index');
    }

    public function show(GameTransfer $gameTransfer)
    {
        abort_if(Gate::denies('game_transfer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.gameTransfers.show', compact('gameTransfer'));
    }

    public function destroy(GameTransfer $gameTransfer)
    {
        abort_if(Gate::denies('game_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gameTransfer->delete();

        return back();
    }

    public function massDestroy(MassDestroyGameTransferRequest $request)
    {
        GameTransfer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
