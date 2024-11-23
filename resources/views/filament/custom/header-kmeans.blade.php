<div>
    <x-filament::breadcrumbs :breadcrumbs="[ '' => $data['master'] ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-3xl">{{ $data['judul'] }}</div>
    </div>
    <div class="flex justify-between mt-1">
        <div class="font-bold text-1xl">Perhitungan K-Means</div>
    </div>
    <div>
        <form wire:submit.prevent="calculateClustering" class="w-full max-w-sm flex mt-3">
            <div class="mb-4">
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-3"
                    id="fileInput" type="number" wire:model="jumlah_cluster">
            </div>
            <div class="flex items-center justify-between mb-4 mt-3">
                <button
                    class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                    style="background-color: blueviolet; margin-left: 8px;">
                    <span wire:loading.remove>Kalkulasi</span>
                    <span wire:loading>Loading...</span>
                </button>
            </div>
        </form>
        <div wire:loading class="mt-3 text-blue-600">
            <svg class="animate-spin h-5 w-5 mr-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Sedang Menghitung, harap tunggu...
        </div>
    </div>
</div>