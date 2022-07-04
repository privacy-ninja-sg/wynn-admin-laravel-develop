<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepositWithdrawTransactionRequest;
use App\Http\Requests\StoreDepositWithdrawTransactionRequest;
use App\Http\Requests\UpdateDepositWithdrawTransactionRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepositWithdrawTransactionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deposit_withdraw_transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.depositWithdrawTransactions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('deposit_withdraw_transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.depositWithdrawTransactions.create');
    }

    public function store(StoreDepositWithdrawTransactionRequest $request)
    {
        $depositWithdrawTransaction = DepositWithdrawTransaction::create($request->all());

        return redirect()->route('admin.deposit-withdraw-transactions.index');
    }

    public function edit(DepositWithdrawTransaction $depositWithdrawTransaction)
    {
        abort_if(Gate::denies('deposit_withdraw_transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.depositWithdrawTransactions.edit', compact('depositWithdrawTransaction'));
    }

    public function update(UpdateDepositWithdrawTransactionRequest $request, DepositWithdrawTransaction $depositWithdrawTransaction)
    {
        $depositWithdrawTransaction->update($request->all());

        return redirect()->route('admin.deposit-withdraw-transactions.index');
    }

    public function show(DepositWithdrawTransaction $depositWithdrawTransaction)
    {
        abort_if(Gate::denies('deposit_withdraw_transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.depositWithdrawTransactions.show', compact('depositWithdrawTransaction'));
    }

    public function destroy(DepositWithdrawTransaction $depositWithdrawTransaction)
    {
        abort_if(Gate::denies('deposit_withdraw_transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depositWithdrawTransaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepositWithdrawTransactionRequest $request)
    {
        DepositWithdrawTransaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
