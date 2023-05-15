<div>

    @if($user->is_approved == 'N')
        <button wire:click="$toggle('showModal')" class="btn btn-success btn-sm mx-1">Approve</button>

        <x-dialog-modal wire:model="showModal">
            <x-slot name="title">
                Registration Approval
            </x-slot>

            <x-slot name="content">

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @else
                    <x-validation-errors class="mb-4" />
                @endif

                Approve registration request of {{$user->name}}?
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    Nevermind
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="approve({{$user->id}})" wire:loading.attr="disabled">
                    Approve
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @else

        <button wire:click="$toggle('showModal')" class="btn btn-danger btn-sm mx-1">Disapprove</button>

        <x-dialog-modal wire:model="showModal">
            <x-slot name="title">
                Registration Approval
            </x-slot>

            <x-slot name="content">

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @else
                    <x-validation-errors class="mb-4" />
                @endif

                Disapprove registration request of {{$user->name}}?
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    Nevermind
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="disapprove({{$user->id}})" wire:loading.attr="disabled">
                    Disapprove
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
