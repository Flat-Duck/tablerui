@php $editing = isset($user) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $user->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="abc1"
            label="Abc1"
            :value="old('abc1', '')"
            maxlength="255"
            placeholder="Abc1"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="abc2" label="Abc2"> </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $user->abc3 ? \Storage::url($user->abc3) : '' }}')"
        >
            <x-inputs.partials.label
                name="abc3"
                label="Abc3"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input type="file" name="abc3" id="abc3" @change="fileChosen" />
            </div>

            @error('abc3') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.partials.label
            name="abc4"
            label="Abc4"
        ></x-inputs.partials.label
        ><br />

        <input type="file" name="abc4" id="abc4" class="form-control-file" />

        @if($editing && $user->abc4)
        <div class="mt-2">
            <a href="{{ \Storage::url($user->abc4) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('abc4') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="abc5"
            label="Abc5"
            :value="old('abc5', '')"
            max="255"
            step="1"
            placeholder="Abc5"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="abc6" label="Abc6" maxlength="255"
            >{{ old('abc6', '') }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email
            name="abc7"
            label="Abc7"
            :value="old('abc7', '')"
            maxlength="255"
            placeholder="Abc7"
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="abc8"
            label="Abc8"
            value="{{ old('abc8', '') }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="abc9"
            label="Abc9"
            value="{{ old('abc9', '') }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password
            name="abc10"
            label="Abc10"
            maxlength="255"
            placeholder="Abc10"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="abc11"
            label="Abc11"
            :checked="old('abc11', '') ? true : false"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.url
            name="abc12"
            label="Abc12"
            :value="old('abc12', '')"
            maxlength="255"
            placeholder="Abc12"
        ></x-inputs.url>
    </x-inputs.group>

    <x-inputs.hidden name="abc13" :value="old('abc13', '')"></x-inputs.hidden>

    @livewire('selects.name-email-email-verified-at-dependent-select', ['user'
    => $editing ? $user->id : null])
</div>
