<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Product;
use App\Models\Contact;
use App\Models\PartyBank;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
// use Stichoza\GoogleTranslate\GoogleTranslate;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parties = Party::all();
        return response()->json($parties, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        // return $request;

        $party = Party::create([
            'firm_name' => $request->firm_name,
            'firm_name_in_ar' => (string) $request->company_name_ar,
            'registration_no' => $request->registration_no,
            // 'registration_no_in_ar'=> $request->registration_no == null ? null : GoogleTranslate::trans(
            //     $request->registration_no,'ar'),
            'vat_no' => $request->vat_no,
            // 'vat_no_in_ar'=> $request->registration_no == null ? null :   GoogleTranslate::trans(
            //     $request->vat_no,'ar'),
            'post_box_no' => $request->post_box_no,
            'street' => $request->street,
            'city' => $request->city,
            'proviance' => $request->proviance,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'party_type' => $request->party_type,
            'contact' => $request->contact,
            'website' => $request->website,
            'fax' => $request->fax,
            'opening_balance' => $request->opening_balance,
            'credit_days' => $request->credit_days,
            'credit_limit' => $request->credit_limit,
            'party_code' => $request->party_code,
            'vendor_id' => $request->vendor_id,
        ]);
        $request->account_no &&
            PartyBank::create([
                'account_no' => $request->account_no,
                'iban_no' => $request->iban_no,
                'bank_name' => $request->bank_name,
                'bank_address' => $request->bank_address,
                'party_id' => $party->id,
            ]);

        $contact = Contact::create([
            'prefix' => $request->prefix,
            'party_id' => $party->id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'designation' => $request->designation,
            'mobno' => $request->mobno,
            'landline' => $request->landline,
            'email' => $request->email,

        ]);

        if ($party->party_code == null) {
            $party->update(['party_code' => 'C-' . sprintf('%05d', $party->id)]);
        }

        return response()->json([$party, $contact], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        $contacts = Contact::where('party_id', '=', $party->id)->get();
        $data =
            [
                'firm_name' => $party->firm_name,
                'firm_name_in_ar' => $party->firm_name_in_ar,
                'registration_no' => $party->registration_no,
                // 'registration_no_in_ar' => $party->registration_no_in_ar,
                'vat_no' => $party->vat_no,
                // 'vat_no_in_ar' => $party->vat_no_in_ar,
                'post_box_no' => $party->post_box_no,
                'street' => $party->street,
                'city' => $party->city,
                'proviance' => $party->proviance,
                'country' => $party->country,
                'zip_code' => $party->zip_code,
                'party_type' => $party->party_type,
                'contact' => $party->contact,
                'website' => $party->website,
                'fax' => $party->fax,
                'opening_balance' => $party->opening_balance,
                'credit_days' => $party->credit_days,
                'credit_limit' => $party->credit_limit,
                'party_code' => $party->party_code,
                'vendor_id' => $party->vendor_id,
                "bank" => $party->bank->map(function ($bankDetail) {
                    return $bankDetail;
                }),
                'contacts' => $contacts->map(function ($contact) {
                    return $contact;
                }),
            ];
        return response()->json(array($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        // $rules = [
        //     'firm_name' => 'required',
        //     'registration_no' => 'required|max:12',
        //     'vat_no' => 'required|max:15',
        //     'post_box_no' => 'required',
        //     'street' => 'required',
        //     'city' => 'required',
        //     'proviance' => 'required',
        //     'country' => 'required',
        //     'zip_code' => 'required',
        //     'party_type' => 'required',
        //     'contact' => 'required',
        //     'fax' => 'required',
        //     'opening_balance' => 'required',
        //     'website' => 'required',
        // ];

        // $messages = ['required' => 'The :attribute field is required.'];

        // $validator = Validator::make($request->all(), $rules, $messages);
        // $errors = $validator->errors();
        // foreach ($errors as $error) {
        //     echo $error;
        // }
        // echo $errors->first('email');

        // if($validator->fails()){
        // return ("somethin went wrong");

        $party->update([
            'firm_name' => $request->firm_name == null ? $party->firm_name : $request->firm_name,
            'firm_name_in_ar' => $request->company_name_ar == null ? $party->firm_name_in_ar : $request->company_name_ar,
            'registration_no' => $request->registration_no == null ? $party->registration_no : $request->registration_no,
            // 'registration_no_in_ar'=> $request->registration_no == null ? $party->registration_no_in_ar : GoogleTranslate::trans($request->registration_no,'ar'),
            'vat_no' => $request->vat_no == null ? $party->vat_no : $request->vat_no,
            // 'vat_no_in_ar'=> $request->registration_no == null ? $party->vat_no_in_ar :   GoogleTranslate::trans($request->vat_no,'ar'),
            'post_box_no' => $request->post_box_no == null ? $party->post_box_no : $request->post_box_no,
            'street' => $request->street == null ? $party->street : $request->street,
            'city' => $request->city == null ? $party->city : $request->city,
            'proviance' => $request->proviance == null ? $party->proviance : $request->proviance,
            'country' => $request->country == null ? $party->country : $request->country,
            'zip_code' => $request->zip_code == null ? $party->zip_code : $request->zip_code,
            'party_type' => $request->party_type == null ? $party->party_type : $request->party_type,
            'contact' => $request->contact == null ? $party->contact : $request->contact,
            'website' => $request->website == null ? $party->website : $request->website,
            'fax' => $request->fax == null ? $party->fax : $request->fax,
            'credit_days' => $request->credit_days == null ? $party->credit_days : $request->credit_days,
            'credit_limit' => $request->credit_limit == null ? $party->credit_limits : $request->credit_limit,
            'opening_balance' => $request->opening_balance == null ? $party->opening_balance : $request->opening_balance,
            'account_no' => $request->account_no == null ? $party->account_no : $request->account_no,
            'iban_no' => $request->iban_no == null ? $party->iban_no :  $request->iban_no,
            'bank_name' => $request->bank_name == null ? $party->bank_name :  $request->bank_name,
            'bank_address' => $request->bank_address == null ? $party->bank_address :  $request->bank_address,
            'party_code' => $request->party_code == null ? $party->party_code :  $request->party_code,
            'vendor_id' => $request->vendor_id == null ? $party->vendor_id :  $request->vendor_id,
        ]);

        return response()->json($party, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        $res = $party->delete();
        if ($res) {
            return (['msg' => 'party' . ' ' . $party->id . ' is successfully deleted']);
        }
    }

    // Api fo vendor list
    public function vendor()
    {
        $vendors = Party::where('party_type', '=', 'vendor')
            ->select('id', 'firm_name', 'contact')
            ->get()
            ->toArray();
        return $vendors;
    }

    // Api for customer list
    public function customer()
    {
        $vendors = Party::where('party_type', '=', 'customer')
            ->select('id', 'firm_name', 'contact')
            ->get()
            ->toArray();
        return $vendors;
    }

    // public function allVendorExcept($product)
    // {
    //     // to get the all vendors excepts product assigned vendor
    //     $product_price = ProductPrice::where('product_id','=',$product)->first();
    //     // dd($product_price);
    //     if($product_price == null){
    //         $vendors = Party::where('party_type', '=', 'vendor')
    //         ->select('id', 'firm_name', 'contact')
    //         ->get()
    //         ->toArray();
    //         return $vendors;
    //     }
    //     else{
    //     $vendors = Party::where('id','!=', $product_price->party_id)
    //     ->orWhere('party_type', '=', 'vendor')
    //     // ->whereNotIn('id',[$party])
    //     ->select('id', 'firm_name', 'contact')
    //     ->get()
    //     ->toArray();
    //     return $vendors;
    //     }
    // }
    public function allVendorExcept($product)
    {
        // $this->product = $product;
        // $vendors = Party::whereNotExists(function ($query) {
        //     $query->select(DB::raw(1))
        //         ->from('product_prices')
        //         ->whereRaw('product_prices.product_id='.$this->product);
        // })
        // ->get();
        $results = DB::select(DB::raw("select * from parties where id not in (select party_id from product_prices where product_id= " . $product . ") and party_type='vendor'
"));

        return response()->json($results);
    }
}
