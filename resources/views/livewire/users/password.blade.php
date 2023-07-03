<div>
        <button wire:click="$toggle('showModal')" class="btn btn-primary btn-sm mx-1">Change</button>

        <x-dialog-modal wire:model="showModal">
            <x-slot name="title">
                Change Password
            </x-slot>

            <x-slot name="content">

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @else
                    <x-validation-errors class="mb-4" />
                @endif

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password" value="{{ __('New Password') }}" />
                    <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="password" autocomplete="new-password" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="password_confirmation" autocomplete="new-password" />
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    Nevermind
                </x-secondary-button>

                <x-success-button class="ml-2" wire:click="save({{$user->id}})" wire:loading.attr="disabled">
                    Save
                </x-success-button>
            </x-slot>
        </x-dialog-modal>
</div>
