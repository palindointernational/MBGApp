<div x-transition>
    <div class="px-4">
        <nav class="bg-white py-2 px-3 relative top-3 items-center rounded-lg flex z-10 shadow-md">
            <div class="flex items-center justify-center">
                @php
                    $colors = ['bg-blue-900', 'bg-green-600', 'bg-red-500', 'bg-purple-600'];
                    $color = $colors[array_rand($colors)];
                @endphp
                <div
                    class="w-12 h-12 rounded-md {{ $color }} text-white flex items-center justify-center mr-3 font-bold text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
            <div class="flex justify-start flex-col">
                <h1 class="text-sm font-bold text-gray-800 ">Hallo, {{ Auth::user()->name }}!
                </h1>
                <h1 class="text-xs font-semibold text-gray-800">
                    {{ $menu ? $menu->kitchen->name : 'Kitchen not found' }}</h1>
            </div>
            <div class="flex flex-col justify-end ml-auto items-end">
                <h1 class="text-lg font-bold text-gray-800">
                    @if ($beneficiaries)
                        {{ $beneficiaries->acceptance_count }}
                    @endif
                </h1>
                <h1 class="text-sm text-gray-600">Makanan Diterima</h1>
            </div>
        </nav>
    </div>
    <section class="flex items-center justify-center relative h-[210px] top-0">
        <img src="https://cdn-web.bgn.go.id/news/01JHGAMFSDZA3V7HC4HMN5EEFE.jpg" alt="Gambar MBG App"
            class="w-full h-46 object-cover rounded-b-3xl">
    </section>
    {{-- Days Menu --}}
    @if ($todayMenu)
        <section x-data="{ showNutrition: false }" @click.outside="showNutrition = false"
            class="p-4 relative z-10 -translate-y-6 mb-4">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <img src="/storage/menu/{{ $todayMenu->image }}" alt="Food"
                    class="w-full h-64 object-cover mb-2 rounded-t-xl">
                <div class="p-4">
                    <h2 class="text-lg font-bold">
                        {{ $todayMenu ? $todayMenu->title : 'Tidak Ada Menu Hari Ini' }}
                    </h2>
                    <p class="text-gray-600 ">
                        {{ Str::limit($todayMenu ? $todayMenu->description : 'Menu not found', 100) }}
                    </p>
                    <div class="flex justify-between items-center mt-4">
                        <div class="text-sm text-gray-600 font-semibold flex items-center gap-1">
                            <svg width="15px" height="15px" viewBox="0 -0.5 21 21" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="Page-1" stroke="currentColor" stroke-width="1" fill="currentColor"
                                    fill-rule="evenodd">
                                    <g id="Dribbble-Light-Preview" transform="translate(-99.000000, -320.000000)"
                                        fill="currentColor">
                                        <g id="icons" transform="translate(56.000000, 160.000000)">
                                            <path
                                                d="M60.556381,172.206 C60.1080307,172.639 59.9043306,173.263 60.0093306,173.875 L60.6865811,177.791 C60.8976313,179.01 59.9211306,180 58.8133798,180 C58.5214796,180 58.2201294,179.931 57.9282291,179.779 L54.3844766,177.93 C54.1072764,177.786 53.8038262,177.714 53.499326,177.714 C53.1958758,177.714 52.8924256,177.786 52.6152254,177.93 L49.0714729,179.779 C48.7795727,179.931 48.4782224,180 48.1863222,180 C47.0785715,180 46.1020708,179.01 46.3131209,177.791 L46.9903714,173.875 C47.0953715,173.263 46.8916713,172.639 46.443321,172.206 L43.575769,169.433 C42.4480682,168.342 43.0707186,166.441 44.6289197,166.216 L48.5916225,165.645 C49.211123,165.556 49.7466233,165.17 50.0227735,164.613 L51.7951748,161.051 C52.143775,160.35 52.8220755,160 53.499326,160 C54.1776265,160 54.855927,160.35 55.2045272,161.051 L56.9769285,164.613 C57.2530787,165.17 57.7885791,165.556 58.4080795,165.645 L62.3707823,166.216 C63.9289834,166.441 64.5516338,168.342 63.423933,169.433 L60.556381,172.206 Z"
                                                id="star_favorite-[#1499]">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>{{ number_format($feedback ?? 0, 1) }}
                        </div>
                        <div class="text-sm text-gray-600 font-semibold flex items-center gap-1">
                            <svg fill="currentColor" width="15px" height="15px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3,7C3,4.239,4.791,2,7,2s4,2.239,4,5a4.913,4.913,0,0,1-3,4.823V21a1,1,0,0,1-2,0V11.823A4.913,4.913,0,0,1,3,7ZM19,3V7H18V3a1,1,0,0,0-2,0V7H15V3a1,1,0,0,0-2,0V8a3,3,0,0,0,3,3V21a1,1,0,0,0,2,0V11a3,3,0,0,0,3-3V3a1,1,0,0,0-2,0Z" />
                            </svg>{{ $menuCount }} Tersalurkan
                        </div>
                    </div>
                    {{-- Menu Section --}}
                    @php
                        $steps = ['Draft', 'Cooking', 'Packing', 'Delivered', 'Distributed'];
                        $currentIndex = array_search($todayMenu->status, $steps);
                    @endphp

                    <ol class="flex items-center w-full justify-center mt-6 p-4">
                        @foreach ($steps as $index => $step)
                            <li class="flex items-center {{ $index < count($steps) - 1 ? 'w-full' : '' }}">
                                <div
                                    class="flex items-center justify-center w-7 h-7 rounded-full z-10
                                                        {{ $index <= $currentIndex ? 'bg-blue-900 text-white' : 'bg-gray-300 text-gray-500' }}">
                                    @switch($step)
                                        @case('Draft')
                                            <svg class="w-4 h-4 text-white" width="24px" height="24px" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.5 6V10H16M14.6847 2L10 2C8.89543 2 8 2.89543 8 4V16C8 17.1046 8.89543 18 10 18L18 18C19.1046 18 20 17.1046 20 16V7.24162C20 6.7034 19.7831 6.18789 19.3982 5.81161L16.0829 2.56999C15.7092 2.2046 15.2074 2 14.6847 2Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M16 18V20C16 21.1046 15.1046 22 14 22H6C4.89543 22 4 21.1046 4 20V9C4 7.89543 4.89543 7 6 7H8"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        @break

                                        @case('Cooking')
                                            <svg fill="currentColor" class="w-4 h-4 text-body" width="24px" height="24px"
                                                viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1"
                                                    d="M76,40V16a12,12,0,0,1,24,0V40a12,12,0,0,1-24,0Zm52,12a12,12,0,0,0,12-12V16a12,12,0,0,0-24,0V40A12,12,0,0,0,128,52Zm40,0a12,12,0,0,0,12-12V16a12,12,0,0,0-24,0V40A12,12,0,0,0,168,52Zm83.2002,53.6001L224,126v58a36.04061,36.04061,0,0,1-36,36H68a36.04061,36.04061,0,0,1-36-36V126L4.7998,105.6001A12.0002,12.0002,0,0,1,19.2002,86.3999L32,96V88A20.02229,20.02229,0,0,1,52,68H204a20.02229,20.02229,0,0,1,20,20v8l12.7998-9.6001a12.0002,12.0002,0,0,1,14.4004,19.2002ZM200,92H56v92a12.01375,12.01375,0,0,0,12,12H188a12.01375,12.01375,0,0,0,12-12Z" />
                                            </svg>
                                        @break

                                        @case('Packing')
                                            <svg fill="currentColor" height="24px" width="24px" class="w-4 h-4 text-body"
                                                version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                                xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1"
                                                            d="M498.769,305.562c-0.036-0.039-0.073-0.075-0.109-0.112c-0.014-0.016-0.027-0.032-0.041-0.048L316.466,112.676 c11.58,5.596,25.089,9.759,39.708,9.759c43.839,0,77.797-37.359,79.221-38.95c5.678-6.34,5.678-15.935,0-22.275 c-1.424-1.589-35.381-38.949-79.221-38.949c-23.866,0-44.788,11.07-59.142,21.416C287.967,30.741,272.959,22.261,256,22.261 c-16.959,0-31.967,8.48-41.032,21.415c-14.354-10.345-35.276-21.415-59.142-21.415c-43.841,0-77.797,37.359-79.221,38.95 c-5.677,6.34-5.677,15.934,0,22.275c1.424,1.589,35.38,38.949,79.221,38.949c14.619,0,28.127-4.163,39.708-9.759L13.377,305.407 c-0.016,0.017-0.029,0.034-0.045,0.051c-0.034,0.038-0.072,0.073-0.108,0.111C4.697,314.837,0,326.88,0,339.478v100.174 c0,27.618,22.469,50.087,50.087,50.087h411.826c27.618,0,50.087-22.469,50.087-50.087V339.478 C512,326.874,507.301,314.829,498.769,305.562z M356.174,55.652c16.372,0,31.633,8.93,41.796,16.681 c-10.181,7.752-25.476,16.71-41.796,16.71c-16.375,0-31.64-8.934-41.797-16.68C324.558,64.611,339.854,55.652,356.174,55.652z M256,55.652c9.206,0,16.693,7.489,16.696,16.692c0,0.002,0,0.003,0,0.006c-0.002,9.205-7.49,16.693-16.696,16.693 c-9.206,0-16.696-7.49-16.696-16.696S246.794,55.652,256,55.652z M155.826,89.043c-16.386,0-31.661-8.947-41.816-16.695 c10.162-7.755,25.434-16.697,41.816-16.697s31.653,8.941,41.815,16.696C187.479,80.102,172.208,89.043,155.826,89.043z M236.143,118.321c6.093,2.641,12.804,4.114,19.857,4.114c7.052,0,13.764-1.473,19.857-4.114l161.685,171.07h-72.434 l-61.826-92.739c-5.116-7.672-15.481-9.745-23.152-4.631c-7.673,5.116-9.746,15.481-4.63,23.152l49.478,74.218H187.022 l49.478-74.218c5.114-7.672,3.041-18.038-4.631-23.152c-7.671-5.113-18.038-3.041-23.152,4.631l-61.826,92.739H74.458 L236.143,118.321z M478.609,439.652c0,9.206-7.49,16.696-16.696,16.696H50.087c-9.206,0-16.696-7.49-16.696-16.696V339.478 c0-4.192,1.559-8.196,4.391-11.283l0.04-0.043c3.2-3.462,7.553-5.369,12.265-5.369h89.043v50.087 c0,9.22,7.475,16.696,16.696,16.696s16.696-7.475,16.696-16.696v-50.087h166.957v50.087c0,9.22,7.475,16.696,16.696,16.696 c9.22,0,16.696-7.475,16.696-16.696v-50.087h89.043c4.713,0,9.067,1.909,12.268,5.374l0.034,0.037 c2.833,3.083,4.393,7.09,4.393,11.285V439.652z" />
                                                    </g>
                                                </g>
                                            </svg>
                                        @break

                                        @case('Delivered')
                                            <svg class="w-5 h-5 text-body" width="24px" height="24px" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18.5 18C18.5 19.1046 17.6046 20 16.5 20C15.3954 20 14.5 19.1046 14.5 18M18.5 18C18.5 16.8954 17.6046 16 16.5 16C15.3954 16 14.5 16.8954 14.5 18M18.5 18H21.5M14.5 18H13.5M8.5 18C8.5 19.1046 7.60457 20 6.5 20C5.39543 20 4.5 19.1046 4.5 18M8.5 18C8.5 16.8954 7.60457 16 6.5 16C5.39543 16 4.5 16.8954 4.5 18M8.5 18H13.5M4.5 18C3.39543 18 2.5 17.1046 2.5 16V7.2C2.5 6.0799 2.5 5.51984 2.71799 5.09202C2.90973 4.71569 3.21569 4.40973 3.59202 4.21799C4.01984 4 4.5799 4 5.7 4H10.3C11.4201 4 11.9802 4 12.408 4.21799C12.7843 4.40973 13.0903 4.71569 13.282 5.09202C13.5 5.51984 13.5 6.0799 13.5 7.2V18M13.5 18V8H17.5L20.5 12M20.5 12V18M20.5 12H13.5"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        @break

                                        @case('Distributed')
                                            <svg class="w-5 h-5 text-body" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                                            </svg>
                                        @break
                                    @endswitch
                                </div>

                                <!-- GARIS -->
                                @if ($index < count($steps) - 1)
                                    <div
                                        class="flex-1 h-1 rounded
                                                            {{ $index < $currentIndex ? 'bg-blue-900' : 'bg-gray-300' }}">
                                    </div>
                                @endif

                            </li>
                        @endforeach
                    </ol>
                    <div class="flex justify-between items-center mt-4 gap-2">
                        @if ($todayMenu && $todayMenu->status == 'Delivered')
                            @if ($hasFeedback)
                                <button
                                    class="bg-blue-200 w-full text-white text-sm font-bold py-2 px-4 rounded-lg cursor-not-allowed"
                                    disabled>
                                    Sudah Memberi Penilaian
                                </button>
                            @else
                                <button @click="page='sendfeedback'"
                                    class="bg-blue-900 hover:bg-blue-700 w-full text-white text-sm font-bold py-2 px-4 rounded-lg">
                                    Sudah Menerima
                                </button>
                            @endif
                        @else
                            <button
                                class="bg-blue-200 w-full text-white text-sm font-bold py-2 px-4 rounded-lg cursor-not-allowed"
                                disabled>
                                Sudah Menerima
                            </button>
                        @endif
                        <button @click="showNutrition = !showNutrition"
                            class="bg-blue-900 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> </button>
                    </div>
                </div>
                <div x-show="showNutrition" x-transition x-cloak class="mt-2 border-t bg-white rounded-b-lg p-4">
                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <caption
                                class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                Informasi Gizi
                                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                                    Jumlah nutrisi untuk memenuhi kebutuhan harianmu.</p>
                            </caption>
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nutrisi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Kalori
                                    </th>
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $nutrision->calories }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Protein
                                    </th>
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $nutrision->protein }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Karbohidrat
                                    </th>
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $nutrision->carbs }}
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Lemak
                                    </th>
                                    <td class="px-6 py-4">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $nutrision->fats }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    @else
        <section class="p-4 relative z-10 -translate-y-6 mb-4">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden h-64">
                <div class="flex flex-col justify-center items-center h-full text-center">
                    <div class="mb-4">
                        <svg fill="currentColor" class="text-gray-300" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="45px" height="45px" viewBox="0 0 177.807 177.807" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M13.463,2.353c-1.508,1.486-2.412,3.655,0.745,16.652c1.891,7.786,16.652,51.198,21.682,63.67
                                                            c10.235,25.374,16.786,24.537,20.539,25.02c1.833,0.236,3.616-0.194,5.157-1.247c4.197-2.864,5.597-3.699,7.218-4.667
                                                            c0.569-0.339,1.176-0.702,1.936-1.169c4.537,7.434,10.138,18.967,15.576,30.163c7.317,15.067,14.884,30.648,20.93,38.71
                                                            c3.845,5.125,8.003,6.633,10.815,6.994c5.382,0.692,10.948-2.192,14.183-7.348c3.281-5.232,3.392-11.437,0.288-16.19
                                                            c-6.389-9.79-99.916-132.93-113.936-149.832C16.65,0.761,14.331,1.497,13.463,2.353z M126.526,165.543
                                                            c-1.839,2.933-4.824,4.597-7.604,4.239c-2.182-0.28-4.353-1.785-6.275-4.349c-5.658-7.543-13.08-22.827-20.259-37.608
                                                            c-6.558-13.503-12.752-26.258-17.819-33.75c-0.565-0.835-1.438-1.337-2.366-1.457c-0.763-0.098-1.564,0.063-2.26,0.513
                                                            c-2.266,1.463-7.795,4.76-12.163,7.741c-0.2,0.137-0.317,0.15-0.49,0.129c-2.315,1.198-2.462-0.561-6.369-5.864
                                                            c-6.293-8.542-24.063-58.716-29.203-75.196c-1.994-6.391,0.13-2.867,1.692-0.857c16.886,21.724,97.263,128.037,103.47,137.548
                                                            C128.849,159.646,127.988,163.212,126.526,165.543z" />
                                    <path d="M176.854,35.658c-1.299-1.338-3.436-1.37-4.772-0.071c-8.615,8.358-16.65,16.508-23.106,23.057
                                                            c-1.649,1.674-3.16,3.206-4.528,4.587l-6.365-6.37l26.897-26.098c1.338-1.298,1.369-3.436,0.071-4.773s-3.434-1.37-4.772-0.071
                                                            l-26.969,26.167l-5.992-5.997l27.058-26.254c1.338-1.299,1.37-3.436,0.072-4.772c-1.298-1.338-3.436-1.37-4.772-0.072
                                                            l-27.129,26.323l-5.837-5.842l29.318-28.447c1.338-1.298,1.37-3.435,0.071-4.771c-1.298-1.339-3.434-1.37-4.771-0.072
                                                            l-33.739,32.737c-8.623,8.366-7.957,20.653,1.438,31.984l-19.189,18.9c-1.338,1.298-1.37,3.435-0.072,4.771
                                                            c0.522,0.538,1.181,0.865,1.867,0.979c1.021,0.17,2.106-0.131,2.906-0.907l19.203-18.914c3.781,3.148,8.251,5.231,12.947,6.011
                                                            c0.604,0.102,1.215,0.18,1.826,0.236c6.129,0.57,11.745-1.144,15.412-4.702c2.342-2.271,5.657-5.635,9.856-9.894
                                                            c6.433-6.524,14.438-14.645,23-22.951C178.119,39.133,178.151,36.996,176.854,35.658z M129.138,71.257
                                                            c-4.737-0.44-9.29-2.684-12.812-6.314c-6.9-7.112-11.598-17.279-4.449-24.758L139.669,68c-0.152,0.148-0.3,0.293-0.444,0.433
                                                            C137.008,70.582,133.238,71.639,129.138,71.257z" />
                                    <path
                                        d="M74.588,116.551c-1.394-1.239-3.527-1.113-4.765,0.281c-13.581,15.281-38.226,42.275-46.542,49.651
                                                            c-4.134,3.667-10.646,2.188-14.133-1.496c-3.647-3.852-3.097-8.73,1.509-13.388c11.695-11.819,28.923-25.353,41.918-35.152
                                                            c1.488-1.122,1.785-3.238,0.663-4.727s-3.238-1.785-4.727-0.663c-13.162,9.926-30.649,23.663-42.652,35.794
                                                            c-8.742,8.837-6.332,17.792-1.612,22.776c2.667,2.815,6.444,4.841,10.456,5.507c4.464,0.741,9.219-0.199,13.057-3.604
                                                            c9.61-8.523,37.265-39.141,47.109-50.218C76.107,119.922,75.981,117.787,74.588,116.551z" />
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-gray-300 font-semibold text-md">Belum ada menu hari
                            ini.
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- Best Menu --}}
    <section class="relative p-4 z-10 -translate-y-20 mb-6">
        <h1 class="font-bold text-gray-800">Menu Terbaik</h1>

        <div class="flex gap-3 mt-4 overflow-x-auto no-scrollbar snap-x snap-mandatory">
            @if (isset($bestMenu) && $bestMenu->count())
                @foreach ($bestMenu as $menu)
                    <div class="min-w-[200px] snap-start bg-white rounded-xl shadow-md overflow-hidden flex-shrink-0">

                        <img src="/storage/menu/{{ $menu->image }}" class="w-full h-40 object-cover">

                        <div class="p-3">
                            <h2 class="font-bold text-sm">{{ $menu->title }}</h2>

                            <p class="text-gray-600 text-xs">
                                {{ Str::limit($menu->description, 40) }}
                            </p>

                            <div class="flex justify-between items-center mt-3">

                                <!-- Rating -->
                                <div class="text-xs text-gray-600 flex items-center gap-1">
                                    <svg width="10px" height="10px" viewBox="0 -0.5 21 21" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="Page-1" stroke="currentColor" stroke-width="1" fill="currentColor"
                                            fill-rule="evenodd">
                                            <g id="Dribbble-Light-Preview"
                                                transform="translate(-99.000000, -320.000000)" fill="currentColor">
                                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                                    <path
                                                        d="M60.556381,172.206 C60.1080307,172.639 59.9043306,173.263 60.0093306,173.875 L60.6865811,177.791 C60.8976313,179.01 59.9211306,180 58.8133798,180 C58.5214796,180 58.2201294,179.931 57.9282291,179.779 L54.3844766,177.93 C54.1072764,177.786 53.8038262,177.714 53.499326,177.714 C53.1958758,177.714 52.8924256,177.786 52.6152254,177.93 L49.0714729,179.779 C48.7795727,179.931 48.4782224,180 48.1863222,180 C47.0785715,180 46.1020708,179.01 46.3131209,177.791 L46.9903714,173.875 C47.0953715,173.263 46.8916713,172.639 46.443321,172.206 L43.575769,169.433 C42.4480682,168.342 43.0707186,166.441 44.6289197,166.216 L48.5916225,165.645 C49.211123,165.556 49.7466233,165.17 50.0227735,164.613 L51.7951748,161.051 C52.143775,160.35 52.8220755,160 53.499326,160 C54.1776265,160 54.855927,160.35 55.2045272,161.051 L56.9769285,164.613 C57.2530787,165.17 57.7885791,165.556 58.4080795,165.645 L62.3707823,166.216 C63.9289834,166.441 64.5516338,168.342 63.423933,169.433 L60.556381,172.206 Z"
                                                        id="star_favorite-[#1499]">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg> {{ number_format($menu->reviews_avg_rating ?? 0, 1) }}
                                </div>

                                <!-- Total -->
                                <div class="text-xs text-gray-600">
                                    {{ $menu->reviews_count }}+ Diterima
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-sm text-gray-500">Belum ada menu terbaik.</p>
            @endif
        </div>
    </section>
</div>
