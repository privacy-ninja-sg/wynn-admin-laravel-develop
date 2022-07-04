<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\Channel;
use App\Models\DepositLog;
use App\Models\Withdraw;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userChannel = Channel::getChannelName();

        if ($request->ajax()) {
            $query = Customer::query()->select(sprintf('%s.*', (new Customer())->table))
                                    ->where(function ($query) use ($request) {
                                        if (!empty($request->start_date) && !empty($request->end_date) ) {
                                            $query->whereDate('created_at','>=', $request->start_date);
                                            $query->wheredate('created_at','<=',$request->end_date);
                                        }
                                    })
                                    ->where(function ($query) use ($request) {
                                        if (!empty($request->user_id) ) {
                                            $query->where('id', $request->user_id);
                                        }
                                    })
                                    ->where(function ($query) use ($request) {
                                        if (!empty($request->username) ) {
                                            $query->where('username', $request->username);
                                        }
                                    });
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use($userChannel) {
                $viewGate = 'customer_show';
                $editGate = 'customer_edit';
                $deleteGate = 'customer_delete';
                $crudRoutePart = 'customers';

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
            $table->editColumn('tel', function ($row) {
                return $row->tel ? $row->tel : '';
            });
            $table->editColumn('picture', function ($row) {
                return $row->picture ? $row->picture : '';
            });
            $table->editColumn('username', function ($row) {
                return $row->username ? $row->username : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Customer::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('bonus', function ($row) {
                return $row->bonus ? Customer::BONUS_SELECT[$row->bonus] : '';
            });
            $table->editColumn('channel_user', function ($row) use($userChannel) {
                return $row->channel_user ? $userChannel[$row->channel_user] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.customers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());

        return redirect()->route('admin.customers.index');
    }

    public function edit(Customer $customer)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        return redirect()->route('admin.customers.index');
    }

    public function show(Customer $customer)
    {
        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankAccounts = BankAccount::where('user_banks',$customer->id)->get();

        $depositlogs = $bankAccounts->isNotEmpty() ? DepositLog::where('user_id',$bankAccounts[0]->id)->get() : [];

        $withdrawlogs = Withdraw::where('user_wallet',$customer->id)->where('txn_type','withdraw')->where('remark','NORMAL-WITHDRAW')->get();

        return view('admin.customers.show', compact('customer','depositlogs','withdrawlogs','bankAccounts'));
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
