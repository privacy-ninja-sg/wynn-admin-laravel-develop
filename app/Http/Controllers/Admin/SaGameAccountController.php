<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySaGameAccountRequest;
use App\Http\Requests\StoreSaGameAccountRequest;
use App\Http\Requests\UpdateSaGameAccountRequest;
use App\Models\SaGameAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaGameAccountController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sa_game_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saGameAccounts = SaGameAccount::all();

        return view('admin.saGameAccounts.index', compact('saGameAccounts'));
    }

    public function create()
    {
        abort_if(Gate::denies('sa_game_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.saGameAccounts.create');
    }

    public function store(StoreSaGameAccountRequest $request)
    {
        $saGameAccount = SaGameAccount::create($request->all());

        return redirect()->route('admin.sa-game-accounts.index');
    }

    public function edit(SaGameAccount $saGameAccount)
    {
        abort_if(Gate::denies('sa_game_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.saGameAccounts.edit', compact('saGameAccount'));
    }

    public function update(UpdateSaGameAccountRequest $request, SaGameAccount $saGameAccount)
    {
        $saGameAccount->update($request->all());

        return redirect()->route('admin.sa-game-accounts.index');
    }

    public function show(SaGameAccount $saGameAccount)
    {
        abort_if(Gate::denies('sa_game_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.saGameAccounts.show', compact('saGameAccount'));
    }

    public function destroy(SaGameAccount $saGameAccount)
    {
        abort_if(Gate::denies('sa_game_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saGameAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroySaGameAccountRequest $request)
    {
        SaGameAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}