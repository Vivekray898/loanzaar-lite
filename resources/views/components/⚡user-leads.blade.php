<?php

use App\Models\Lead;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $leads;

    public function mount(): void
    {
        $this->leads = Lead::with(['form', 'values.formField', 'statusLogs'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'new' => 'bg-gray-100 text-gray-800',
            'contacted' => 'bg-yellow-100 text-yellow-800',
            'in_review' => 'bg-blue-100 text-blue-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
};
?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">My Applications</h2>
        <div class="text-sm text-gray-600">
            Total: {{ $leads->count() }}
        </div>
    </div>

    @if($leads->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by submitting your first application.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($leads as $lead)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $lead->form->name }}</h3>
                                <p class="text-sm text-gray-500">Submitted on {{ $lead->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $this->getStatusColor($lead->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Application Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($lead->values as $value)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ $value->formField->label }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $value->value ?: '—' }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($lead->statusLogs->count() > 1)
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Status History</h4>
                                <div class="space-y-2">
                                    @foreach($lead->statusLogs->take(3) as $log)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <span>{{ ucfirst(str_replace('_', ' ', $log->new_status)) }}</span>
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($lead->notes)
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Notes</h4>
                                <p class="text-sm text-gray-600">{{ $lead->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>