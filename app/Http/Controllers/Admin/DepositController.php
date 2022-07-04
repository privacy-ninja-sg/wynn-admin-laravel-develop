<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepositRequest;
use App\Http\Requests\StoreDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Models\Deposit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('deposit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Deposit::query()->select(sprintf('%s.*', (new Deposit())->table))
                            ->where('txn_type','deposit')
                            ->where(function ($query) use ($request) {
                                if (!empty($request->start_date) && !empty($request->end_date) ) {
                                    $query->whereDate('created_at','>=', $request->start_date);
                                    $query->wheredate('created_at','<=',$request->end_date);
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (!empty($request->user_wallet) ) {
                                    $query->where('user_wallet', $request->user_wallet);
                                }
                            });
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'deposit_show';
                $editGate = 'deposit_edit';
                $deleteGate = 'deposit_delete';
                $crudRoutePart = 'deposits';

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
            $table->editColumn('debit', function ($row) {
                return $row->debit ? $row->debit : '';
            });
            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });
            $table->editColumn('txn_type', function ($row) {
                return $row->txn_type ? $row->txn_type : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Deposit::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('user_wallet', function ($row) {
                return $row->user_wallet ? $row->user_wallet : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.deposits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('deposit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deposits.create');
    }

    public function store(StoreDepositRequest $request)
    {
        $deposit = Deposit::create($request->all());

        return redirect()->route('admin.deposits.index');
    }

    public function edit(Deposit $deposit)
    {
        abort_if(Gate::denies('deposit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deposits.edit', compact('deposit'));
    }

    public function update(UpdateDepositRequest $request, Deposit $deposit)
    {
        $deposit->update($request->all());

        return redirect()->route('admin.deposits.index');
    }

    public function show(Deposit $deposit)
    {
        abort_if(Gate::denies('deposit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deposits.show', compact('deposit'));
    }

    public function destroy(Deposit $deposit)
    {
        abort_if(Gate::denies('deposit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposit->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepositRequest $request)
    {
        Deposit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
