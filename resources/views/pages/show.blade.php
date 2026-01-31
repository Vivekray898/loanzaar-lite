<x-layouts.app>
    <div class="bg-white">
        {{-- Hero/Header Section --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-4">{{ $page->title }}</h1>
                @if($page->meta_description)
                    <p class="text-xl text-blue-100">{{ $page->meta_description }}</p>
                @endif
            </div>
        </div>

        {{-- Page Sections --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @foreach($page->sections as $section)
                <div class="mb-12">
                    @if($section->type === 'hero')
                        <div class="text-center">
                            @if($section->title)
                                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $section->title }}</h2>
                            @endif
                            @if($section->content)
                                <div class="text-lg text-gray-600 max-w-3xl mx-auto">
                                    {!! nl2br(e($section->content['description'] ?? '')) !!}
                                </div>
                            @endif
                        </div>

                    @elseif($section->type === 'benefits')
                        <div>
                            @if($section->title)
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $section->title }}</h2>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @if($section->content && isset($section->content['items']))
                                    @foreach($section->content['items'] as $item)
                                        <div class="bg-gray-50 rounded-lg p-6">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item['title'] ?? '' }}</h3>
                                            <p class="text-gray-600">{{ $item['description'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    @elseif($section->type === 'features')
                        <div>
                            @if($section->title)
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $section->title }}</h2>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @if($section->content && isset($section->content['features']))
                                    @foreach($section->content['features'] as $feature)
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $feature['title'] ?? '' }}</h3>
                                                <p class="mt-2 text-gray-600">{{ $feature['description'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    @elseif($section->type === 'faq')
                        <div>
                            @if($section->title)
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $section->title }}</h2>
                            @endif
                            <div class="space-y-4">
                                @if($section->content && isset($section->content['questions']))
                                    @foreach($section->content['questions'] as $faq)
                                        <div class="bg-gray-50 rounded-lg p-6">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $faq['question'] ?? '' }}</h3>
                                            <p class="text-gray-600">{{ $faq['answer'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    @elseif($section->type === 'cta')
                        <div class="bg-blue-50 rounded-lg p-8 text-center">
                            @if($section->title)
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $section->title }}</h2>
                            @endif
                            @if($section->content && isset($section->content['button_text']))
                                <a href="{{ $section->content['button_url'] ?? '#' }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                                    {{ $section->content['button_text'] }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Attached Form --}}
            @if($page->form)
                <div class="mt-12 border-t pt-12">
                    <livewire:dynamic-form :slug="$page->form->slug" />
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
