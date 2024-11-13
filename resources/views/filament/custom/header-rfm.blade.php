<div>
    <x-filament::breadcrumbs :breadcrumbs="[
    'superadmin/r-f-m-s' => 'RFM',
    '' => 'RFM Preview',
    ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-3xl">{{ $tab['master'] }}</div>
        <div>
            {{ $data }}
        </div>
    </div>
</div>