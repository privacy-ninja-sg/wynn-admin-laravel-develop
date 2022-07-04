<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPgSlotAccountRequest;
use App\Http\Requests\StorePgSlotAccountRequest;
use App\Http\Requests\UpdatePgSlotAccountRequest;
use App\Models\PgSlotAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PgSlotAccountController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pg_slot_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pgSlotAccounts = PgSlotAccount::all();

        return view('admin.pgSlotAccounts.index', compact('pgSlotAccounts'));
    }

    public function create()
    {
        abort_if(Gate::denies('pg_slot_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pgSlotAccounts.create');
    }

    public function store(StorePgSlotAccountRequest $request)
    {
        $pgSlotAccount = PgSlotAccount::create($request->all());

        return redirect()->route('admin.pg-slot-accounts.index');
    }

    public function edit(PgSlotAccount $pgSlotAccount)
    {
        abort_if(Gate::denies('pg_slot_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pgSlotAccounts.edit', compact('pgSlotAccount'));
    }

    public function update(UpdatePgSlotAccountRequest $request, PgSlotAccount $pgSlotAccount)
    {
        $pgSlotAccount->update($request->all());

        return redirect()->route('admin.pg-slot-accounts.index');
    }

    public function show(PgSlotAccount $pgSlotAccount)
    {
        abort_if(Gate::denies('pg_slot_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pgSlotAccounts.show', compact('pgSlotAccount'));
    }

    public function destroy(PgSlotAccount $pgSlotAccount)
    {
        abort_if(Gate::denies('pg_slot_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pgSlotAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroyPgSlotAccountRequest $request)
    {
        PgSlotAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
