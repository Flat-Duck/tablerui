<div class="w-100 p-0">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="name" label="Name" wire:model="selectedName">
            <option selected>Please select the name</option>
            @foreach($allNames as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedName))
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="email" label="Email" wire:model="selectedEmail">
            <option selected>Please select the email</option>
            @foreach($allEmails as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif @if(!empty($selectedEmail))
    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="email_verified_at"
            label="Email Verified At"
            wire:model="selectedEmailVerifiedAt"
        >
            <option selected>Please select the email_verified_at</option>
            @foreach($allEmailVerifiedAts as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
