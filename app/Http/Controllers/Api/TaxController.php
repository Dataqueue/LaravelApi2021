<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function saleTax(Request $request)
    {
        if ($request->from_date) {
            $invoiceCollection = Invoice::whereBetween('created_at', [$request->from_date . ' ' . '00:00:00', $request->to_date ? $request->to_date . ' ' . '23:59:59' : now()])->get();
        } else {
            $invoiceCollection = Invoice::whereBetween('created_at', [date("Y-m") . '-01' . ' ' . '00:00:00', $request->to_date ? $request->to_date . ' ' . '23:59:59' : now()])->get();
        }

        return response()->json($invoiceCollection);
    }

    public function purchaseTax(Request $request)
    {
        if ($request->from_date) {
            $expenseCollection = Expense::whereBetween('created_at', [$request->from_date . ' ' . '00:00:00', $request->to_date ? $request->to_date . ' ' . '23:59:59' : now()])->get();
        } else {
            $expenseCollection = Expense::whereBetween('created_at', [ date("Y-m") . '-01'. ' ' . '00:00:00', $request->to_date ? $request->to_date . ' ' . '23:59:59' : now()])->get();
        }

        return response()->json($expenseCollection);
    }
}
