<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
        $currentYear = date('Y');
        $randomNum = rand(100, 999);
        $receiptNo = "AT-{$currentYear}-{$randomNum}";
        $currentDate = date('d F Y'); // e.g. 22 June 2026

        return view('invoices.create', compact('receiptNo', 'currentDate'));
    }
}
