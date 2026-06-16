<x-base-layout>
    <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('invoices.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-sm transition-colors">← {{ __('All Invoices') }}</a>
            </div>
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $invoice->invoice_number }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $invoice->created_at->format('d-m-Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($invoice->isPaid())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                        {{ __('Paid') }}
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">
                        {{ __('Pending') }}
                    </span>
                    @endif
                    <a href="{{ route('invoices.download', $invoice) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        {{ __('Download PDF') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Parties --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3">{{ __('From (Freelancer)') }}</p>
                        <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $invoice->freelancer->firstname }} {{ $invoice->freelancer->lastname }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $invoice->freelancer->email }}</p>
                        @if($invoice->freelancer->address)
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $invoice->freelancer->address }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $invoice->freelancer->postal_code }} {{ $invoice->freelancer->city }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3">{{ __('To (Client)') }}</p>
                        <p class="font-semibold text-slate-800 dark:text-slate-100">{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $invoice->client->email }}</p>
                        @if($invoice->client->address)
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $invoice->client->address }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $invoice->client->postal_code }} {{ $invoice->client->city }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Line items --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-200">{{ __('Details') }}</h2>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50">
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Description') }}</th>
                            <th class="text-right px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100 dark:border-slate-700">
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                {{ $invoice->commission->title }}
                                @if($invoice->offer?->message)
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $invoice->offer->message }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-800 dark:text-slate-200">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200 text-right">{{ __('Total') }}</td>
                            <td class="px-6 py-4 text-right font-bold text-lg text-slate-900 dark:text-white">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Payment status / actions --}}
            @if($invoice->isPaid())
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl px-6 py-4">
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    {{ __('Payment received on') }} {{ $invoice->paid_at->format('d-m-Y') }}
                </p>
            </div>
            @elseif(auth()->user()->isClient() && $invoice->client_id === auth()->id())
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl px-6 py-4 flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-amber-800 dark:text-amber-300">{{ __('Payment pending') }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">{{ __('Transfer the amount to the freelancer and mark this invoice as paid.') }}</p>
                </div>
                <form method="POST" action="{{ route('invoices.mark-paid', $invoice) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="shrink-0 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        {{ __('Mark as paid') }}
                    </button>
                </form>
            </div>
            @endif

        </div>
    </section>
</x-base-layout>
