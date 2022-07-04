<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPrettyGameAccountRequest;
use App\Http\Requests\StorePrettyGameAccountRequest;
use App\Http\Requests\UpdatePrettyGameAccountRequest;
use App\Models\PrettyGameAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrettyGameAccountController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pretty_game_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prettyGameAccounts = PrettyGameAccount::all();

        return view('admin.prettyGameAccounts.index', compact('prettyGameAccounts'));
    }

    public function create()
    {
        abort_if(Gate::denies('pretty_game_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.prettyGameAccounts.create');
    }

    public function store(StorePrettyGameAccountRequest $request)
    {
        $prettyGameAccount = PrettyGameAccount::create($request->all());

        return redirect()->route('admin.pretty-game-accounts.index');
    }

    public function edit(PrettyGameAccount $prettyGameAccount)
    {
        abort_if(Gate::denies('pretty_game_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.prettyGameAccounts.edit', compact('prettyGameAccount'));
    }

    public function update(UpdatePrettyGameAccountRequest $request, PrettyGameAccount $prettyGameAccount)
    {
        $prettyGameAccount->update($request->all());

        return redirect()->route('admin.pretty-game-accounts.index');
    }

    public function show(PrettyGameAccount $prettyGameAccount)
    {
        abort_if(Gate::denies('pretty_game_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.prettyGameAccounts.show', compact('prettyGameAccount'));
    }

    public function destroy(PrettyGameAccount $prettyGameAccount)
    {
        abort_if(Gate::denies('pretty_game_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prettyGameAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrettyGameAccountRequest $request)
    {
        PrettyGameAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
