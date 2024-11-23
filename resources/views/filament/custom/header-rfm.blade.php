<div>
    <x-filament::breadcrumbs :breadcrumbs="[ '' => $data['master'] ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-1xl">{{ $data['judul'] }}</div>
    </div>
    <div>
        <hr style="border: 2px solid #808080;margin-top:0.7rem;">
        <hr style="border: 2px solid #808080;margin-top:0.1rem;margin-bottom:0.2rem;">
        <form wire:submit.prevent="calculateRFM" class="w-full flex flex-row space-x-3 mt-3">
            <div class="flex-1">
                <label for="startdate" class="block text-gray-700 font-bold mb-2">Start Date:</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="startdate" type="date" wire:model="start_date">
            </div>

            <div class="flex-1 ml-2">
                <div>
                    <label for="enddate" class="block text-gray-700 font-bold mb-2">End Date:</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="enddate" type="date" wire:model="end_date">
                </div>
            </div>

            <div class="flex items-end">
                <div style="margin-left: 0.2rem;">
                    <button
                        class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit"
                        style="background-color: blueviolet;">
                        <span wire:loading.remove>Kalkulasi</span>
                        <span wire:loading>Loading...</span>
                    </button>
                </div>
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