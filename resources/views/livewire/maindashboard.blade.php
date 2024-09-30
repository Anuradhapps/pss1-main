
<div>
<button wire:click="test1">dsdsd</button>
</div>

	        			<div>
                        <select id="1" wire:model.lazy="selecteddistrict" class="form-control w-full text-green-900" wire:change="clear1()" wire:loading.attr="disabled">
                            <option value="" selected>Select District</option>
                            @foreach($dis as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        </div>

						<div>
                        <select id="2" wire:model.lazy="selectedasc" class="form-control w-full text-green-900" wire:change="clear2()" wire:loading.attr="disabled">
                            <option value="" selected>Select ASC</option>
                            @foreach($asc as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        </div>






