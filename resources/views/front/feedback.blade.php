<div x-transition>
    <div class="p-4 bg-white shadow-sm">
        <h1 class="font-bold text-gray-800 text-xl">
            Penilaian Saya
        </h1>
    </div>
    {{-- feedback --}}
    @if (optional($beneficiaries)->reviews?->isNotEmpty())
        <section id="feedback" class=" p-4">
            {{-- feedback 1 --}}
            @foreach ($beneficiaries->reviews as $feedbacks)
                <div>
                    <div class="px-4">
                        <div
                            class="bg-white py-2 px-3 relative top-3 items-center rounded-lg flex z-10 border-gray-100 border-b-2">
                            <div class="flex items-center justify-center">
                                <img src="/storage/menu/{{ $feedbacks->menu->image }}" alt="Profile Picture"
                                    class="w-12 h-12 rounded-md object-cover mr-3">
                            </div>
                            <div class="flex justify-start flex-col">
                                <h1 class="text-sm font-bold text-gray-800 ">
                                    {{ $feedbacks->menu->title ?? 'Menu tidak ditemukan' }}
                                </h1>
                                <h1 class="text-xs font-semibold text-gray-800">
                                    {{ Str::limit($feedbacks->menu->description ?? 'Deskripsi tidak tersedia', 50) }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 bg-white w-full border-gray-100 border-b-4 p-4">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-row gap-1 items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg width="25px" height="25px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m12 17.328-5.403 3.286a.75.75 0 0 1-1.12-.813l1.456-6.155-4.796-4.123a.75.75 0 0 1 .428-1.316l6.303-.517 2.44-5.835a.75.75 0 0 1 1.384 0l2.44 5.835 6.303.517a.75.75 0 0 1 .427 1.316l-4.795 4.123 1.456 6.155a.75.75 0 0 1-1.12.813L12 17.328z"
                                            fill="{{ $i <= ($feedbacks->rating ?? 0) ? '#FFCE1B' : '#D1D5DB' }}" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-400 text-sm mb-2">
                                {{ $feedbacks->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="text-gray-600 mb-2">{{ $feedbacks->comment }}</p>
                        <img src="/storage/feedback/{{ $feedbacks->image }}" alt=""
                            class="w-20 h-20 object-cover rounded-lg">
                    </div>
                </div>
            @endforeach
        </section>
    @else
        <section class="p-4">
            <div class="p-6 text-center h-full">
                <p class="text-gray-400">Belum ada feedback.</p>
            </div>
        </section>
    @endif
</div>
