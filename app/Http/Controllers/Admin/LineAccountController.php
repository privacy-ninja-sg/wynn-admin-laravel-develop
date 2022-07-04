<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLineAccountRequest;
use App\Http\Requests\StoreLineAccountRequest;
use App\Http\Requests\UpdateLineAccountRequest;
use App\Models\LineAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LineAccountController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('line_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lineAccounts = LineAccount::all();

        return view('admin.lineAccounts.index', compact('lineAccounts'));
    }

    public function create()
    {
        abort_if(Gate::denies('line_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lineAccounts.create');
    }

    public function store(StoreLineAccountRequest $request)
    {
        $lineAccount = LineAccount::create($request->all());

        return redirect()->route('admin.line-accounts.index');
    }

    public function edit(LineAccount $lineAccount)
    {
        abort_if(Gate::denies('line_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lineAccounts.edit', compact('lineAccount'));
    }

    public function update(UpdateLineAccountRequest $request, LineAccount $lineAccount)
    {
        $lineAccount->update($request->all());

        return redirect()->route('admin.line-accounts.index');
    }

    public function show(LineAccount $lineAccount)
    {
        abort_if(Gate::denies('line_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lineAccounts.show', compact('lineAccount'));
    }

    public function destroy(LineAccount $lineAccount)
    {
        abort_if(Gate::denies('line_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lineAccount->delete();

        return back();
    }

    public function massDestroy(MassDestroyLineAccountRequest $request)
    {
        LineAccount::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
