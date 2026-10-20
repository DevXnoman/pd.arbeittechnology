<?php

namespace App\Http\Controllers;

use App\Models\MoneyReceipt;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
        $currentYear = date('Y');
        
        // Find next sequential number or unique 3-4 digit random receipt number
        do {
            $randomNum = rand(100, 999);
            $receiptNo = "AT-{$currentYear}-{$randomNum}";
        } while (MoneyReceipt::where('receipt_no', $receiptNo)->exists());

        $currentDate = date('d F Y'); // e.g. 18 October 2026
        $projects = Project::orderBy('project_name', 'asc')->get(['id', 'project_name', 'client_name', 'client_phone']);

        $prefillProject = null;
        if ($request->filled('project_id')) {
            $prefillProject = Project::find($request->project_id);
        }

        return view('invoices.create', compact('receiptNo', 'currentDate', 'projects', 'prefillProject'));
    }

    public function show($id)
    {
        $receipt = MoneyReceipt::findOrFail($id);
        $receiptNo = $receipt->receipt_no;
        $currentDate = Carbon::parse($receipt->receipt_date)->format('d F Y');
        $projects = Project::orderBy('project_name', 'asc')->get(['id', 'project_name', 'client_name', 'client_phone']);

        return view('invoices.create', compact('receipt', 'receiptNo', 'currentDate', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receipt_no' => 'required|string|max:100',
            'receipt_date' => 'required|string',
            'client_name' => 'required|string|max:255',
            'amount_received' => 'required',
        ]);

        // Clean amount values (strip BDT, commas, spaces)
        $cleanAmount = (float) preg_replace('/[^0-9.]/', '', $request->amount_received);
        $cleanDue = $request->filled('due_balance') ? (float) preg_replace('/[^0-9.]/', '', $request->due_balance) : 0;

        try {
            $parsedDate = Carbon::parse($request->receipt_date)->format('Y-m-d');
        } catch (\Exception $e) {
            $parsedDate = now()->toDateString();
        }

        $receipt = MoneyReceipt::updateOrCreate(
            ['receipt_no' => trim($request->receipt_no)],
            [
                'receipt_date' => $parsedDate,
                'client_name' => trim($request->client_name),
                'client_contact' => $request->client_contact ? trim($request->client_contact) : null,
                'client_address' => $request->client_address ? trim($request->client_address) : null,
                'purpose' => $request->purpose ? trim($request->purpose) : null,
                'amount_received' => $cleanAmount,
                'payment_method' => $request->payment_method ? trim($request->payment_method) : 'bKash',
                'due_balance' => $cleanDue,
                'signatory_name' => $request->signatory_name ?: 'MD. Ali Akbar',
                'signatory_designation' => $request->signatory_designation ?: 'Managing Director',
                'project_id' => $request->project_id ?: null,
                'notes' => $request->notes ?: null,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Money receipt saved successfully!',
                'receipt' => $receipt,
                'redirect_url' => route('invoices.show', $receipt->id),
            ]);
        }

        return redirect()->route('invoices.show', $receipt->id)
            ->with('success', 'Money Receipt saved and linked to Accounts successfully!');
    }

    public function destroy($id)
    {
        $receipt = MoneyReceipt::findOrFail($id);
        $receipt->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('accounts.index')->with('success', 'Money Receipt deleted successfully!');
    }
}
