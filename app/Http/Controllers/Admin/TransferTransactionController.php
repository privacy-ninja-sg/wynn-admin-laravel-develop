<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTransferTransactionRequest;
use App\Http\Requests\StoreTransferTransactionRequest;
use App\Http\Requests\UpdateTransferTransactionRequest;
use App\Models\TransferTransaction;
use App\Models\Game;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TransferTransactionController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('transfer_transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TransferTransaction::query()->select(sprintf('%s.*', (new TransferTransaction())->table))
                                                ->where(function ($query) use ($request) {
                                                    if (!empty($request->start_date) && !empty($request->end_date) ) {
                                                        $query->whereDate('created_at','>=', $request->start_date);
                                                        $query->wheredate('created_at','<=',$request->end_date);
                                                    }
                                                })
                                                ->where(function ($query) use ($request) {
                                                    if (!empty($request->user_transfers) ) {
                                                        $query->where('user_transfers', $request->user_transfers);
                                                    }
                                                })
                                                ->where(function ($query) use ($request) {
                                                    if (!empty($request->status) ) {
                                                        $query->where('status', $request->status);
                                                    }
                                                });
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'transfer_transaction_show';
                $editGate = 'transfer_transaction_edit';
                $deleteGate = 'transfer_transaction_delete';
                $crudRoutePart = 'transfer-transactions';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? TransferTransaction::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('user_transfers', function ($row) {
                return $row->user_transfers ? $row->user_transfers : '';
            });
            $table->editColumn('game_transfers', function ($row) {
                return $row->game->name ? $row->game->name : '';
            });
            $table->editColumn('txn_type', function ($row) {
                return $row->txn_type ? TransferTransaction::TXN_TYPE_SELECT[$row->txn_type] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.transferTransactions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('transfer_transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transferTransactions.create');
    }

    public function store(StoreTransferTransactionRequest $request)
    {
        $transferTransaction = TransferTransaction::create($request->all());

        return redirect()->route('admin.transfer-transactions.index');
    }

    public function edit(TransferTransaction $transferTransaction)
    {
        abort_if(Gate::denies('transfer_transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transferTransactions.edit', compact('transferTransaction'));
    }

    public function update(UpdateTransferTransactionRequest $request, TransferTransaction $transferTransaction)
    {
        $transferTransaction->update($request->all());

        return redirect()->route('admin.transfer-transactions.index');
    }

    public function show(TransferTransaction $transferTransaction)
    {
        abort_if(Gate::denies('transfer_transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transferTransactions.show', compact('transferTransaction'));
    }

    public function destroy(TransferTransaction $transferTransaction)
    {
        abort_if(Gate::denies('transfer_transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transferTransaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyTransferTransactionRequest $request)
    {
        TransferTransaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
