<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Party;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AccountStatementController extends Controller
{

    public function getInvoiceData($party_id,  $to_date, $from_date = null)
    {
        $temp = new Collection();
        $temp = Invoice::join('parties','invoices.party_id','parties.id')->where('party_id', $party_id)->select(
            'parties.credit_days',
            'invoices.*'
    )
            ->whereBetween('invoices.created_at', [$from_date . ' ' . '00:00:00', $to_date . ' ' . '23:59:59'])->get();
        return $temp;
    }

    public function getReceiptData($party_id,  $to_date, $from_date = null)
    {
        $temp = new Collection();
        $temp = Receipt::join('parties','receipts.party_id','parties.id')->where('party_id', $party_id)->select(
            'parties.credit_days',
            'receipts.*'
    )->where('party_id', $party_id)
            ->whereBetween('receipts.created_at', [$from_date . ' ' . '00:00:00', $to_date . ' ' . '23:59:59'])->get();
        return $temp;
    }


    public function accountStatement(Request $request)
    {
        $party = Party::where('id', intval($request['party_id']))->first();
        if (!$party) {
            return response('No party exists by this id', 400);
        }

        // -----------------------------------
        $partyOpeningBalance = floatval($party->opening_balance);

        $oldInvoiceCollection = $this->getInvoiceData($party->id, $request['from_date']);
        $oldReceiptCollection = $this->getReceiptData($party->id, $request['from_date']);
        $oldData = $oldInvoiceCollection->merge($oldReceiptCollection);
        if (!$oldData) {
            return response()->json(['msg' => "There are no entries between" . $request['from_date'] . " to " . $request['from_date']], 400);
        }
        $oldData = $oldData->sortBy('created_at');

        foreach ($oldData as $key => $item) {
            if ($item->total_value) {
                $partyOpeningBalance += floatVal($item['total_value']);
            }

            if ($item->paid_amount) {
                $partyOpeningBalance -= floatVal($item['paid_amount']);
            }
        }
        // ------------------------------------


        $invoiceCollection = $this->getInvoiceData($party->id, $request['to_date'], $request['from_date']);

        $receiptCollection = $this->getReceiptData($party->id, $request['to_date'], $request['from_date']);
        $data = $invoiceCollection->merge($receiptCollection);
        $data = $data->sortBy('created_at');

        $data && ( $datas['data'] = $data->map(function ($item)  {
            if ($item->total_value) {
                $item['date'] = $item->created_at;
                $item['code_no'] = $item->invoice_no;
                $item['description'] = "Sale";
                $item['debit'] = $item->total_value;
                $item['po_number'] = $item->po_number;
                $item['credit_days'] = floatval($item->credit_days);
                $item['credit'] = null;
                return [ $item ];
            }

            if ($item->paid_amount) {
                $item['date'] = $item->created_at;
                $item['code_no'] = $item->receipt_no;
                $item['description'] = "Received";
                $item['credit'] = $item->paid_amount;
                $item['po_number'] = $item->po_number;
                $item['credit_days'] = floatval($item->credit_days);
                $item['debit'] = null;
                return [$item];

            }
        }));

        !$data && $datas['data'] = null;
        $datas['opening_balance'] = $partyOpeningBalance;
        $datas['firm_name'] = $party->firm_name;
        $datas['credit_days'] = $party->credit_days;
        $datas['from_date'] = $request['from_date'];
        $datas['to_date'] = $request['to_date'];

        return response()->json([$datas]);
    }

    public function allAccountStatement(Request $request)
    {
        $invoiceCollection = new Collection();
        if($request->from_date){
            $invoiceCollection = Invoice::join('parties','invoices.party_id','parties.id')->select('parties.credit_days','invoices.*')->whereBetween('invoices.created_at', [$request->from_date . ' ' . '00:00:00', $request->to_date ? $request->to_date . ' ' . '23:59:59' : now()])->get();
        }else{
            $invoiceCollection = Invoice::all();
        }

        $receiptCollection = new Collection();
        if($request->from_date){
            $receiptCollection = Receipt::join('parties','receipts.party_id','parties.id')->select('parties.credit_days','receipts.*')->whereBetween('receipts.created_at', [$request->from_date . ' ' . '00:00:00', $request->to_date ? $request->to_date. ' ' . '23:59:59' : now()])->get();
        }else{
            $receiptCollection = Receipt::all();
        }

        $data = $invoiceCollection->merge($receiptCollection);
        $data = $data->sortBy('created_at');

        $data && ($datas['data'] = $data->map(function ($item) {
            if ($item->total_value) {
                $item['date'] = $item->created_at;
                $item['code_no'] = $item->invoice_no;
                $item['description'] = "Sale";
                $item['debit'] = floatval(str_replace(",","",$item->total_value));
                $item['po_number'] = $item->po_number;
                $item['credit'] = null;
                $item['credit_days'] = floatval($item->credit_days);
                return [$item];
            }

            if ($item->paid_amount) {
                $item['date'] = $item->created_at;
                $item['code_no'] = $item->receipt_no;
                $item['description'] = "Received";
                $item['credit'] = floatval(str_replace(",","",$item->paid_amount));
                $item['po_number'] = $item->po_number;
                $item['debit'] = null;
                $item['credit_days'] = floatval($item->credit_days);
                return [$item];
            }
        }));
        $datas['opening_balance'] = 0;
        $datas['name'] = "All";
        $datas['from_date'] = $request['from_date'] ? $request['from_date'] : "2021-01-01";
        $datas['to_date'] = $request['to_date'] ? $request['to_date'] : substr(now(), 0, 10);

        return response()->json([$datas]);
    }
}
