<div>

    <!-- Judul Halaman -->
    <x-filament::breadcrumbs :breadcrumbs="[
    '' => $data['master'] ,
    ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-3xl">{{ $data['judul'] }}</div>
    </div>

    <livewire:transaksi-chart />

    <!-- Form Unggah File -->
    <div>
        <form wire:submit="save" class="w-full max-w-sm flex mt-2">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput">
                    Pilih Berkas
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="fileInput" type="file" wire:model="file">
            </div>
            <div class="flex items-center justify-between mt-3">
                <button
                    class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit" style="background-color: blueviolet;margin-left:8px">
                    Unggah
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .chart-container {
        position: relative;
        width: 100%;
        max-width: 100%;
        height: 400px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .chart-container {
            height: 300px;
        }
    }
    
</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>