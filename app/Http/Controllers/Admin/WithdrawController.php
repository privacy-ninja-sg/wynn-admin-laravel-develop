<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWithdrawRequest;
use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Requests\UpdateWithdrawRequest;
use App\Models\Withdraw;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function index(Request $request)
    { 
        abort_if(Gate::denies('withdraw_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Withdraw::query()->select(sprintf('%s.*', (new Withdraw())->table))
                                    ->where('txn_type','withdraw')
                                    ->where('remark','NORMAL-WITHDRAW')
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
                $viewGate = 'withdraw_show';
                $editGate = 'withdraw_edit';
                $deleteGate = 'withdraw_delete';
                $crudRoutePart = 'withdraws';

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
            $table->editColumn('credit', function ($row) {
                return $row->credit ? $row->credit : '';
            });
            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Withdraw::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('user_wallet', function ($row) {
                return $row->user_wallet ? $row->user_wallet : '';
            });
            $table->editColumn('user_bank_id', function ($row) {
                return $row->user->bankAccount->bank_account_id ? $row->user->bankAccount->bank_account_id : '';
            });
            $table->editColumn('user_bank', function ($row) {
                return $row->user->bankAccount->bank->short_name ? $row->user->bankAccount->bank->short_name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.withdraws.index');
    }

    public function create()
    {
        abort_if(Gate::denies('withdraw_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.withdraws.create');
    }

    public function store(StoreWithdrawRequest $request)
    {
        $withdraw = Withdraw::create($request->all());

        return redirect()->route('admin.withdraws.index');
    }

    public function edit(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.withdraws.edit', compact('withdraw'));
    }

    public function update(UpdateWithdrawRequest $request, Withdraw $withdraw)
    {
        $withdraw->update($request->all());

        return redirect()->route('admin.withdraws.index');
    }

    public function show(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.withdraws.show', compact('withdraw'));
    }

    public function destroy(Withdraw $withdraw)
    {
        abort_if(Gate::denies('withdraw_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $withdraw->delete();

        return back();
    }

    public function massDestroy(MassDestroyWithdrawRequest $request)
    {
        Withdraw::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateStatus(Request $request)
    {
        // Update Status
        Withdraw::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json(['error' => 0, 'message' => 'update success']);
    }
}
