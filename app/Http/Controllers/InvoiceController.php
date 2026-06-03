<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $invoices = $user->isClient()
            ? $user->clientInvoices()->with(['commission', 'freelancer'])->latest()->get()
            : $user->freelancerInvoices()->with(['commission', 'client'])->latest()->get();

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $invoice->load(['commission.category', 'client', 'freelancer', 'offer']);

        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorizeAccess($invoice);

        $invoice->load(['commission.category', 'client', 'freelancer', 'offer']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-'.$invoice->invoice_number.'.pdf');
    }

    public function markPaid(Invoice $invoice)
    {
        $user = auth()->user();

        if ($invoice->client_id !== $user->id) {
            abort(403);
        }

        if ($invoice->isPending()) {
            $invoice->update(['status' => 'paid', 'paid_at' => now()]);
        }

        return back()->with('success', 'Invoice marked as paid.');
    }

    private function authorizeAccess(Invoice $invoice): void
    {
        $user = auth()->user();

        if ($invoice->client_id !== $user->id && $invoice->freelancer_id !== $user->id) {
            abort(403);
        }
    }
}
