<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBankRequest;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Bank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BankController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banks = Bank::all();

        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        abort_if(Gate::denies('bank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.create');
    }

    public function store(StoreBankRequest $request)
    {
        $bank = Bank::create($request->all());

        return redirect()->route('admin.banks.index');
    }

    public function edit(Bank $bank)
    {
        abort_if(Gate::denies('bank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.edit', compact('bank'));
    }

    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $bank->update($request->all());

        return redirect()->route('admin.banks.index');
    }

    public function show(Bank $bank)
    {
        abort_if(Gate::denies('bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.banks.show', compact('bank'));
    }

    public function destroy(Bank $bank)
    {
        abort_if(Gate::denies('bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bank->delete();

        return back();
    }

    public function massDestroy(MassDestroyBankRequest $request)
    {
        Bank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
