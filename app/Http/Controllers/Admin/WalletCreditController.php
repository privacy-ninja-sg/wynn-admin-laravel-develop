<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Requests\MassDestroyWalletCreditRequest;
// use App\Http\Requests\StoreWalletCreditRequest;
// use App\Http\Requests\UpdateWalletCreditRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletCreditController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('wallet_credit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletCredits.index');
    }

    /*public function create()
    {
        abort_if(Gate::denies('wallet_credit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletCredits.create');
    }

    public function store(StoreWalletCreditRequest $request)
    {
        $walletCredit = WalletCredit::create($request->all());

        return redirect()->route('admin.wallet-credits.index');
    }

    public function edit(WalletCredit $walletCredit)
    {
        abort_if(Gate::denies('wallet_credit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletCredits.edit', compact('walletCredit'));
    }

    public function update(UpdateWalletCreditRequest $request, WalletCredit $walletCredit)
    {
        $walletCredit->update($request->all());

        return redirect()->route('admin.wallet-credits.index');
    }

    public function show(WalletCredit $walletCredit)
    {
        abort_if(Gate::denies('wallet_credit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletCredits.show', compact('walletCredit'));
    }

    public function destroy(WalletCredit $walletCredit)
    {
        abort_if(Gate::denies('wallet_credit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletCredit->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletCreditRequest $request)
    {
        WalletCredit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }*/

    public function addCredit(Request $request)
    {
        abort_if(Gate::denies('wallet_credit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = auth()->user();
        $params['wallet_id'] = intval($request->wallet_id);
        $params['amount'] = floatval($request->amount);
        $params['remark'] = 'ADMIN:'.$user->id;

        // $responseRaw = $this->curlPost(env('API_CHECK_WALLETCREDIT'), json_encode(['last_bank_id' => "1095"]));
        $responseRaw = $this->curlPost(env('API_ADD_WALLETCREDIT'), json_encode($params));
        $resp = json_decode($responseRaw);
        if ($resp->code == 200) {
            return response()->json(['s' => 'ok','code' => 200]);
        }else{
            return response(null,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function curlPost($url,$params)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $params,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic aDBnV1lKOHp3UzoxNmhmbmx9NFQsKihxTGY=',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
