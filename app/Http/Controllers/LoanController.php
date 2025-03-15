<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return response()->json(Loan::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:borrowed,returned,late',
        ]);

        $loan = Loan::create($validated);

        return response()->json($loan, 201);
    }

    public function show(Loan $loan)
    {
        return response()->json($loan, 200);
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'book_id' => 'sometimes|exists:books,id',
            'user_id' => 'sometimes|exists:users,id',
            'loan_date' => 'sometimes|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'sometimes|in:borrowed,returned,late',
        ]);

        $loan->update($validated);

        return response()->json($loan, 200);
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(['message' => 'Loan deleted successfully'], 200);
    }
}
