<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\MoneyReceipt;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        // 1. Gather all available months from both Money Receipts and Expenses
        $driver = DB::connection()->getDriverName();
        $receiptFormat = $driver === 'sqlite' ? "strftime('%Y-%m', receipt_date)" : "DATE_FORMAT(receipt_date, '%Y-%m')";
        $expenseFormat = $driver === 'sqlite' ? "strftime('%Y-%m', expense_date)" : "DATE_FORMAT(expense_date, '%Y-%m')";

        $receiptMonths = MoneyReceipt::whereNotNull('receipt_date')
            ->selectRaw("{$receiptFormat} as ym, MAX(receipt_date) as max_date")
            ->groupBy('ym')
            ->orderByDesc('max_date')
            ->pluck('max_date')
            ->map(fn($date) => Carbon::parse($date)->format('F Y'))
            ->unique()
            ->values()
            ->toArray();

        $expenseMonths = Expense::whereNotNull('expense_date')
            ->selectRaw("{$expenseFormat} as ym, MAX(expense_date) as max_date")
            ->groupBy('ym')
            ->orderByDesc('max_date')
            ->pluck('max_date')
            ->map(fn($date) => Carbon::parse($date)->format('F Y'))
            ->unique()
            ->values()
            ->toArray();

        $allMonths = array_values(array_unique(array_merge($receiptMonths, $expenseMonths)));
        
        $currentMonth = date('F Y');
        if (empty($allMonths)) {
            $allMonths = [$currentMonth];
        } elseif (!in_array($currentMonth, $allMonths)) {
            array_unshift($allMonths, $currentMonth);
        }

        // Selected month (e.g., 'October 2026', or 'all')
        $selectedMonth = $request->input('month');
        if (!$selectedMonth) {
            $selectedMonth = in_array($currentMonth, $allMonths) ? $currentMonth : ($allMonths[0] ?? $currentMonth);
        }

        // 2. Base queries
        $receiptsQuery = MoneyReceipt::with('project');
        $expensesQuery = Expense::query();

        if ($selectedMonth !== 'all') {
            try {
                $carbonDate = Carbon::createFromFormat('F Y', $selectedMonth);
                $year = $carbonDate->year;
                $month = $carbonDate->month;

                $receiptsQuery->whereYear('receipt_date', $year)->whereMonth('receipt_date', $month);
                $expensesQuery->whereYear('expense_date', $year)->whereMonth('expense_date', $month);
            } catch (\Exception $e) {
                // If format fails, fallback to current month
                $receiptsQuery->whereMonth('receipt_date', date('m'))->whereYear('receipt_date', date('Y'));
                $expensesQuery->whereMonth('expense_date', date('m'))->whereYear('expense_date', date('Y'));
            }
        }

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $receiptsQuery->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('receipt_no', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%");
            });

            $expensesQuery->where(function ($q) use ($search) {
                $q->where('purpose', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('spent_by', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $receipts = $receiptsQuery->orderBy('receipt_date', 'desc')->orderBy('id', 'desc')->get();
        $expenses = $expensesQuery->orderBy('expense_date', 'desc')->orderBy('id', 'desc')->get();

        // 3. KPI Metrics
        $totalInflow = (float) $receipts->sum('amount_received');
        $totalExpenses = (float) $expenses->sum('amount');
        $netBalance = $totalInflow - $totalExpenses;

        // Market Outstanding Due: calculate latest recorded due per client or total open due
        $totalDue = (float) MoneyReceipt::select('client_name', DB::raw('MAX(id) as last_id'))
            ->groupBy('client_name')
            ->pluck('last_id')
            ->pipe(function ($lastIds) {
                return MoneyReceipt::whereIn('id', $lastIds)->sum('due_balance');
            });

        // 4. Predefined expense categories with UI badge styling
        $categories = [
            'Office Equipment' => ['bg' => 'bg-indigo-100 text-indigo-800 border-indigo-200', 'icon' => 'devices'],
            'Utility & Internet' => ['bg' => 'bg-sky-100 text-sky-800 border-sky-200', 'icon' => 'wifi'],
            'Food & Snacks' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => 'coffee'],
            'Office Rent' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'icon' => 'apartment'],
            'Software & Hosting' => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'cloud'],
            'Marketing & Ads' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'campaign'],
            'Salary & Honorarium' => ['bg' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'badge'],
            'Miscellaneous' => ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'icon' => 'receipt_long'],
        ];

        return view('accounts.index', compact(
            'allMonths',
            'selectedMonth',
            'receipts',
            'expenses',
            'totalInflow',
            'totalExpenses',
            'netBalance',
            'totalDue',
            'categories'
        ));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'expense_date' => 'required|date',
            'purpose' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'spent_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense = Expense::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Office expense added successfully!',
                'expense' => $expense,
            ]);
        }

        $month = Carbon::parse($expense->expense_date)->format('F Y');
        return redirect()->route('accounts.index', ['month' => $month])
            ->with('success', 'Office expense recorded successfully!');
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_date' => 'required|date',
            'purpose' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'spent_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Expense updated successfully!',
                'expense' => $expense,
            ]);
        }

        return redirect()->back()->with('success', 'Expense updated successfully!');
    }

    public function destroyExpense(Request $request, Expense $expense)
    {
        $expense->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Expense deleted successfully!');
    }

    public function export(Request $request)
    {
        $month = $request->input('month', 'all');
        
        $receiptsQuery = MoneyReceipt::query();
        $expensesQuery = Expense::query();

        if ($month !== 'all') {
            try {
                $carbonDate = Carbon::createFromFormat('F Y', $month);
                $receiptsQuery->whereYear('receipt_date', $carbonDate->year)->whereMonth('receipt_date', $carbonDate->month);
                $expensesQuery->whereYear('expense_date', $carbonDate->year)->whereMonth('expense_date', $carbonDate->month);
            } catch (\Exception $e) {}
        }

        $receipts = $receiptsQuery->orderBy('receipt_date', 'desc')->get();
        $expenses = $expensesQuery->orderBy('expense_date', 'desc')->get();

        $safeMonth = preg_replace('/[^a-zA-Z0-9_-]/', '_', $month);
        $fileName = "Accounts_Statement_{$safeMonth}_" . date('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($receipts, $expenses, $month) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel

            // Summary Header
            fputcsv($handle, ["ACCOUNTS STATEMENT - ARBEIT TECHNOLOGY", "PERIOD: " . strtoupper($month)]);
            fputcsv($handle, ["Generated on: " . date('d M Y, h:i A')]);
            fputcsv($handle, ["Total Inflow (Received)", number_format($receipts->sum('amount_received'), 2) . " BDT"]);
            fputcsv($handle, ["Total Expenses", number_format($expenses->sum('amount'), 2) . " BDT"]);
            fputcsv($handle, ["Net Balance", number_format($receipts->sum('amount_received') - $expenses->sum('amount'), 2) . " BDT"]);
            fputcsv($handle, []);

            // 1. INFLOW SECTION
            fputcsv($handle, ["=== CLIENT PAYMENTS & INFLOW ==="]);
            fputcsv($handle, ['#', 'Receipt No', 'Date', 'Client Name', 'Contact', 'Purpose', 'Payment Method', 'Amount Received (BDT)', 'Due Balance (BDT)']);
            foreach ($receipts as $i => $r) {
                fputcsv($handle, [
                    $i + 1,
                    $r->receipt_no,
                    $r->receipt_date ? $r->receipt_date->format('Y-m-d') : '',
                    $r->client_name,
                    "\t" . ($r->client_contact ?? ''),
                    $r->purpose,
                    $r->payment_method,
                    $r->amount_received,
                    $r->due_balance,
                ]);
            }
            fputcsv($handle, []);

            // 2. EXPENSES SECTION
            fputcsv($handle, ["=== OFFICE EXPENSES ==="]);
            fputcsv($handle, ['#', 'Date', 'Purpose', 'Category', 'Amount (BDT)', 'Spent By', 'Notes']);
            foreach ($expenses as $i => $e) {
                fputcsv($handle, [
                    $i + 1,
                    $e->expense_date ? $e->expense_date->format('Y-m-d') : '',
                    $e->purpose,
                    $e->category,
                    $e->amount,
                    $e->spent_by,
                    $e->notes,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
