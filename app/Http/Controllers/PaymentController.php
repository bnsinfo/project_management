<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Get type from query: received or paid
        $type = $request->get('type', 'received'); // default = received

        // Validate type
        if (!in_array($type, ['received', 'paid'])) {
            $type = 'received';
        }

        // Filter payments based on type
        $payments = Payment::with('project')
            ->where('payment_type', $type)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('payments.index', [
            'payments' => $payments,
            'type' => $type,
        ]);
    }


    public function create()
    {
        $projects = Project::orderBy('title')->get();

        return view('payments.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'payment_note' => 'nullable|string',
            'payment_type' => 'required|in:received,paid',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment added successfully.');
    }

    public function edit(Payment $payment)
    {
        $projects = Project::orderBy('title')->get();

        return view('payments.edit', compact('payment', 'projects'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:1',
            'payment_note' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
