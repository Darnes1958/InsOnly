<div class="text-sm ">

    <div class="flex gap-2  justify-between">
        <div class="flex  gap-6">
            <div class="flex gap-2">
                <x-label  class="text-primary-400" for="radio1" value="{{ __('بالتجميعي') }}"/>
                <x-input type="radio" class="ml-4" wire:model.live="By" name="radio1" value="2" />
            </div>
            <div class="flex gap-2">
                <x-label  class="text-primary-400" for="radio2" value="{{ __('بفروع المصارف') }}"/>
                <x-input type="radio" class="ml-4" wire:model.live="By" name="radio2" value="1"/>
            </div>
        </div>

    </div>


    @if($By==1)
        <div class="w-full mt-2">
            {{ $this->table }}
        </div>
    @else
        <livewire:rep-taj-sum/>
    @endif

</div>
