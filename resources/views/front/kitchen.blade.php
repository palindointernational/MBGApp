<div x-transition>
    <div class="relative p-4 bg-white shadow-sm z-10">
        <h1 class="font-bold text-gray-800 text-xl">
            Informasi Dapur
        </h1>
    </div>
    @if ($menu && $menu->kitchen)
        <section class="flex items-center relative h-[210px] top-0">
            <iframe src="https://maps.google.com/maps?q={{ urlencode($menu->kitchen->name) }}&output=embed"
                class="w-full h-full" style="border:0;" loading="lazy">
            </iframe>
        </section>
        <div class="p-4 flex flex-col justify-start">
            <div class="border-b border-gray-200 py-2">
                <div class="text-gray-500 text-sm">Nama Dapur</div>
                <div class="text-gray-700 text-lg font-bold">
                    {{ $menu ? $menu->kitchen->name : 'Kitchen not found' }}</div>
            </div>
            <div class="border-b border-gray-200 py-2">
                <div class="text-gray-500 text-sm">Kontak</div>
                <div class="text-gray-700 text-lg font-bold">
                    {{ $menu ? $menu->kitchen->phone : 'Kitchen not found' }}</div>
            </div>
            <div class="border-b border-gray-200 py-2">
                <div class="text-gray-500 text-sm">Alamat</div>
                <div class="text-gray-700 text-lg font-bold">
                    {{ $menu ? $menu->kitchen->address : 'Kitchen not found' }}</div>
            </div>
        </div>
    @else
        <div class="p-8 text-center">
            <p class="text-gray-400">
                Data dapur belum tersedia.
            </p>
        </div>
    @endif
</div>
