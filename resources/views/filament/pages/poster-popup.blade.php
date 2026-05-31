<x-filament-panels::page>
    <form wire:submit.prevent="save" class="space-y-6">

        {{ $this->form }}

        <div class="flex justify-end">
            <x-filament::button type="submit">
                <span wire:loading.remove>Simpan Poster</span>
                <span wire:loading>Menyimpan...</span>
            </x-filament::button>
        </div>

    </form>
</x-filament-panels::page>
