<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceDetail;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentYear()
    {
        return substr(date('Y'), 2);
    }

    public function getLastInvoiceNo()
    {
        $invoice = PurchaseInvoice::latest('created_at')->first();
        if ($invoice) {
            $latest_invoice_no = $invoice->invoice_no ? $invoice->invoice_no : 0;
            return ($latest_invoice_no);
        } else {
            return ('AMINV-' . $this->getCurrentYear() . '-' . sprintf("%04d", 0));
        }
    }

    public function getInvoiceNo()
    {
        $latest_invoice_no = $this->getLastInvoiceNo();
        $last_year = substr($latest_invoice_no, 6, 2);
        $current_year = $this->getCurrentYear();
        // dd([$last_year, $current_year]);
        if ($current_year != $last_year) {
            return ('AMINV-' . $current_year . '-' . sprintf("%04d", 1));
        } else {
            return ('AMINV-' . $current_year . '-' . sprintf("%04d", ((int)substr($this->getLastInvoiceNo(), 9)) + 1));
        }
    }
    public function index()
    {
        $invoices = PurchaseInvoice::where('status','!=','Delivered')
        ->orderBy('created_at','DESC')->get();
        return $invoices;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();
        // dd($data);
        // dd($request->vat_in_value);
        // dd($request->vat_in_value);
        // $data['invoice_no'] = $this->getInvoiceNo();
        $data['issue_date'] = $request['issue_date'];
        $data['status'] = "New";
        $data['quotation_id'] = $request['quotation_id'];
        $data['total_value'] = $request['total_value'];
        $data['discount_in_percentage'] = $request['discount_in_percentage'];
        $data['vat_in_value'] = $request['vat_in_value'];
        $data['grand_total'] = $request['grand_total'];
        $data['bill_no'] = $request['bill_no'];
        $invoice = PurchaseInvoice::create([
            'invoice_no' => $data['invoice_no'],
            'issue_date' => $data['issue_date'],
            'status' => $data['status'],
            'quotation_id' => $data['quotation_id'],
            'total_value' => $data['total_value'],
            'discount_in_percentage' => $data['discount_in_percentage'],
            'vat_in_value' => $data['vat_in_value'],
            'grand_total' => $data['grand_total'],
            'bill_no' => $data['bill_no'],
        ]);

        global $_invoice_id;
        $_invoice_id = $invoice['id'];

        foreach($data['invoice_details'] as $invoice_detail) {
            $_invoice_detail = PurchaseInvoiceDetail::create([
                'quotation_detail_id' => $invoice_detail['id'],
                'product_id' => $invoice_detail['product_id'],
                'sell_price' => $invoice_detail['sell_price'],
                'quantity' => $invoice_detail['quantity'],
                'total_amount' => $invoice_detail['total_amount'],
                'purchase_invoice_id' => $_invoice_id,
            ]);
        }
        // return 'success';
        return response()->json($invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        return [
            $purchaseInvoice,
            $purchaseInvoice->quotation->party,
            // $purchaseInvoice->quotation->quotationDetail,
            $purchaseInvoice->purchaseInvoiceDetail->map(function ($purchaseInvoice_detail){
                return [
                    $purchaseInvoice_detail->quotationDetail,
                    $purchaseInvoice_detail->product,
                ];
            }),
            // $invoice->invoiceDetail->map(function ($invoice_detail){
            //     return [
            //         $invoice_detail->quotationDetail,
            //     ];
            // }),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */

    public function getCurrentDeliveryYear()
    {
        return substr(date('Y'), 2);
    }

    public function getLastDeliveryNo()
    {
        $invoice = PurchaseInvoice::latest('created_at')->first();
        if ($invoice) {
            $latest_bill_no = $invoice->bill_no ? $invoice->bill_no : 0;
            return ($latest_bill_no);
        } else {
            return ('AMDLV-' . $this->getCurrentDeliveryYear() . '-' . sprintf("%04d", 0));
        }
    }

    public function getDeliveryNo()
    {
        $latest_bill_no = $this->getLastDeliveryNo();
        $last_year = substr($latest_bill_no, 6, 2);
        $current_year = $this->getCurrentDeliveryYear();
        // dd([$last_year, $current_year]);
        if ($current_year != $last_year) {
            return ('AMDLV-' . $current_year . '-' . sprintf("%04d", 1));
        } else {
            return ('AMDLV-' . $current_year . '-' . sprintf("%04d", ((int)substr($this->getLastDeliveryNo(), 9)) + 1));
        }
    }

    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $data = $request->all();
        // $data['status'] = 'Delivered';
        // $data['bill_no'] = $this->getDeliveryNo();
        $purchaseInvoice->update($data);
        return $purchaseInvoice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        return ($purchaseInvoice->delete());
    }

    // public function history()
    // {
    //     $invoices = PurchaseInvoice::where('status', '=', 'Delivered')
    //     ->orderBy('created_at', 'DESC')->get();
    //     return response()->json($invoices);
    // }

    public function purchaseInvoiceList()
    {
        $quotations = Quotation::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('purchase_invoices')
                ->whereRaw('purchase_invoices.quotation_id = quotations.id');
        })
        ->where("transaction_type",'purchase')
        ->orderBy('created_at', 'DESC')
        ->get();

        $quotations_data =
            $quotations->map(
                function ($quotation) {
                    $data = [
                        'id' => $quotation->id,
                        'po_number' => $quotation->po_number,
                        'created_at' => $quotation->created_at,
                        'updated_at' => $quotation->updated_at,
                        'status' => $quotation->status,
                        'total_value' => $quotation->total_value,
                        'party_id' => $quotation->party_id,
                        "contact_id" => $quotation->contact_id,
                        "contact" => $quotation->contact,
                        "party" => $quotation->party,
                        "vat_in_value" => $quotation->vat_in_value,
                        "net_amount" => $quotation->net_amount,
                        "transaction_type" => $quotation->transaction_type,
                        'discount_in_p' => $quotation->discount_in_p,
                        'ps_date' => $quotation->ps_date,
                        'quotation_details' => $quotation->quotationDetail->map(function ($quotation_detail) {
                            $quotation_detail = QuotationDetail::where('id', '=', $quotation_detail->id)->first();
                            return [
                                "id" => $quotation_detail['id'],
                                "created_at" => $quotation_detail->created_at,
                                "updated_at" => $quotation_detail->updated_at,
                                "product_id" => $quotation_detail->product_id,
                                "product" => array($quotation_detail->product),
                                "description" => $quotation_detail->description,
                                "quantity" => $quotation_detail->quantity,
                                "total_amount" => $quotation_detail->total_amount,
                                "analyse_id" => $quotation_detail->analyse_id,
                                "purchase_price" => $quotation_detail->purchase_price,
                                "margin" => $quotation_detail->margin,
                                "sell_price" => $quotation_detail->sell_price,
                                "remark" => $quotation_detail->remark,
                            ];
                        }),
                    ];
                    return $data;
                }
            );

        return response()->json($quotations_data, 200);
    }
    public function PurchaseInvoice()
    {
        // $data = purchase_invoices::create([
        //     'total_value' => $request['total_value'],
        //     'discount_in_percentage' => $request['discount_in_p'],
        //     'vat_in_value' => $request['vat_in_value'],
        //     'grand_total' => $request['net_amount'],
        // ]);
        return response()->json(null);
    }
}



