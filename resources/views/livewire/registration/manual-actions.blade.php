<div>
    <button wire:click="$toggle('showModal')" class="btn btn-success btn-sm mx-1">View</button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Manual Registration
        </x-slot>

        <x-slot name="content">
            <p class="mt-6 text-gray-500 leading-relaxed text-left">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @else
                    <x-validation-errors class="mb-4" />
                @endif

                <div>
                    @csrf

                    @php
                        $venues = \DB::table('venue')
                            ->select('*')
                            ->whereNot('venue_id', 'V00')
                            ->get();
                    @endphp
                    <div>
                        <x-label for="venue_id" value="{{ __('Attended Venue') }}" />
                        <select name="venue_id" id="venue_id"
                            class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2 mt-2" wire:model="venue_id"
                            style="width:100%" required autofocus>
                            @foreach ($venues as $v)
                                <option value="{{ $v->venue_id }}"
                                    {{ $v->venue_id == ($venue_id  == '' ? \Auth::user()->venue_id : $venue_id ) ? 'selected' : '' }}>
                                    {{ $v->venue_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="account_code" value="{{ __('Account Number') }}" />
                        <x-input id="account_code" class="block mt-1 w-full" type="text" name="account_code" wire:model="account_code"
                            required autofocus autocomplete="account_code" readonly/>
                        @error('account_code') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="consumer_name" value="{{ __('Name') }}" />
                        <x-input id="consumer_name" class="block mt-1 w-full" type="text" name="consumer_name" wire:model="consumer_name"
                            required autofocus autocomplete="consumer_name" readonly/>
                        @error('consumer_name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="address" value="{{ __('Address') }}" />
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address" wire:model="address"
                            required autofocus autocomplete="address" readonly/>
                        @error('address') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="regname" value="{{ __('Registered By') }}" />
                        <x-input id="regname" class="block mt-1 w-full" type="text" name="regname" wire:model="regname"
                            required autofocus autocomplete="regname" />
                        @error('regname') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="contact" value="{{ __('Contact') }}" />
                        <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" wire:model="contact"
                            required autofocus autocomplete="contact" />
                        @error('contact') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </p>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                Close
            </x-secondary-button>

            @if (\Auth::user()->role == 'admin' || \Auth::user()->role == 'register')
            <x-danger-button class="ml-2" wire:click="delete('{{$consumer->account_no}}')" wire:loading.attr="disabled">
                Delete
            </x-danger-button>

            <x-success-button class="ml-2" wire:click="update('{{$consumer->account_no}}')" wire:loading.attr="disabled">
                Update
            </x-success-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
