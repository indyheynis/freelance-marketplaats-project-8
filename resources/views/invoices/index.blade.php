<x-base-layout>
    <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-1">{{ __('Invoices') }}</h1>
            <p class="text-slate-500 dark:text-slate-400">{{ __('Overview of all your invoices') }}</p>
        </div>
    </section>

    <section class="py-12 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if($invoices->isEmpty())
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('No invoices yet') }}</h3>
                <p class="text-slate-500 dark:text-slate-400">{{ __('Invoices are created automatically when an offer is accepted.') }}</p>
            </div>
            @else
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50">
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Invoice') }}</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Commission') }}</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">
                                @if(auth()->user()->isClient()) {{ __('Freelancer') }} @else {{ __('Client') }} @endif
                            </th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Amount') }}</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Status') }}</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-700 dark:text-slate-300">{{ __('Date') }}</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-mono font-medium text-slate-800 dark:text-slate-200">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $invoice->commission->title ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                @if(auth()->user()->isClient())
                                    {{ $invoice->freelancer->firstname }} {{ $invoice->freelancer->lastname }}
                                @else
                                    {{ $invoice->client->firstname }} {{ $invoice->client->lastname }}
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($invoice->isPaid())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                    {{ __('Paid') }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">
                                    {{ __('Pending') }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $invoice->created_at->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium text-sm transition-colors">
                                        {{ __('View') }}
                                    </a>
                                    <a href="{{ route('invoices.download', $invoice) }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium text-sm transition-colors">
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </section>
</x-base-layout>
