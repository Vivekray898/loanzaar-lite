<?php

use App\Models\Form;
use App\Models\Lead;
use App\Models\LeadStatusLog;
use App\Models\LeadValue;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

new class extends Component
{
    public ?Form $form = null;

    public array $formData = [];

    public bool $submitted = false;

    public function mount(string $slug): void
    {
        $this->form = Form::with('fields')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Initialize form data array
        foreach ($this->form->fields as $field) {
            $this->formData[$field->name] = '';
        }
    }

    public function submit(): void
    {
        // Build validation rules dynamically
        $rules = [];
        foreach ($this->form->fields as $field) {
            $fieldRules = [];

            if ($field->is_required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            // Add type-specific validation
            match ($field->type) {
                'email' => $fieldRules[] = 'email',
                'number' => $fieldRules[] = 'numeric',
                'tel' => $fieldRules[] = 'string',
                'url' => $fieldRules[] = 'url',
                'date' => $fieldRules[] = 'date',
                default => $fieldRules[] = 'string',
            };

            // Add custom validation rules if defined
            if ($field->validation_rules) {
                $fieldRules = array_merge($fieldRules, $field->validation_rules);
            }

            $rules['formData.'.$field->name] = $fieldRules;
        }

        $this->validate($rules);

        DB::transaction(function () {
            // Create lead
            $lead = Lead::create([
                'form_id' => $this->form->id,
                'user_id' => auth()->id(),
                'status' => 'new',
                'source' => 'direct',
            ]);

            // Save field values
            foreach ($this->form->fields as $field) {
                LeadValue::create([
                    'lead_id' => $lead->id,
                    'form_field_id' => $field->id,
                    'value' => $this->formData[$field->name] ?? null,
                ]);
            }

            // Create initial status log
            LeadStatusLog::create([
                'lead_id' => $lead->id,
                'old_status' => null,
                'new_status' => 'new',
                'changed_by' => auth()->id(),
                'notes' => 'Lead created via form submission',
            ]);
        });

        $this->submitted = true;

        // Redirect if URL is set
        if ($this->form->redirect_url) {
            $this->redirect($this->form->redirect_url);
        }
    }
};
?>

<div class="w-full max-w-2xl mx-auto">
    @if($submitted)
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h3 class="text-lg font-semibold text-green-900">Thank You!</h3>
            </div>
            <div class="text-green-800">
                {!! $form->thank_you_message ?? 'Your submission has been received successfully. We will get back to you soon.' !!}
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-2">{{ $form->name }}</h2>
            @if($form->description)
                <p class="text-gray-600 mb-6">{{ $form->description }}</p>
            @endif

            <form wire:submit="submit" class="space-y-4">
                @foreach($form->fields as $field)
                    <div>
                        <label for="field-{{ $field->name }}" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $field->label }}
                            @if($field->is_required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        @if($field->type === 'textarea')
                            <textarea
                                id="field-{{ $field->name }}"
                                wire:model="formData.{{ $field->name }}"
                                rows="4"
                                placeholder="{{ $field->placeholder }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('formData.'.$field->name) border-red-500 @enderror"
                            ></textarea>
                        @elseif($field->type === 'select')
                            <select
                                id="field-{{ $field->name }}"
                                wire:model="formData.{{ $field->name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('formData.'.$field->name) border-red-500 @enderror"
                            >
                                <option value="">Select an option</option>
                                @if($field->options)
                                    @foreach($field->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif($field->type === 'radio')
                            <div class="space-y-2">
                                @if($field->options)
                                    @foreach($field->options as $option)
                                        <label class="inline-flex items-center mr-4">
                                            <input
                                                type="radio"
                                                wire:model="formData.{{ $field->name }}"
                                                value="{{ $option }}"
                                                class="form-radio text-blue-600"
                                            >
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        @elseif($field->type === 'checkbox')
                            <div class="space-y-2">
                                @if($field->options)
                                    @foreach($field->options as $option)
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                wire:model="formData.{{ $field->name }}"
                                                value="{{ $option }}"
                                                class="form-checkbox text-blue-600"
                                            >
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        @else
                            <input
                                type="{{ $field->type }}"
                                id="field-{{ $field->name }}"
                                wire:model="formData.{{ $field->name }}"
                                placeholder="{{ $field->placeholder }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('formData.'.$field->name) border-red-500 @enderror"
                            >
                        @endif

                        @if($field->help_text)
                            <p class="mt-1 text-sm text-gray-500">{{ $field->help_text }}</p>
                        @endif

                        @error('formData.'.$field->name)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="flex justify-end pt-4">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Submit</span>
                        <span wire:loading>Submitting...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>