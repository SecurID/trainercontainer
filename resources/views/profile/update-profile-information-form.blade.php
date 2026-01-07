<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <flux:heading size="lg">{{ __('Profile Information') }}</flux:heading>
        <flux:text class="mt-1 text-zinc-600">{{ __('Update your account\'s profile information and email address.') }}</flux:text>

        <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}">
                    <input type="file" class="hidden"
                                wire:model.live="photo"
                                x-ref="photo"
                                x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                " />

                    <flux:label>{{ __('Photo') }}</flux:label>

                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <div class="mt-2" x-show="photoPreview">
                        <span class="block rounded-full w-20 h-20"
                              x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <flux:button class="mt-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </flux:button>

                    <flux:error name="photo" class="mt-2" />
                </div>
            @endif

            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input wire:model="state.name" autocomplete="name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" wire:model="state.email" autocomplete="email" />
                <flux:error name="email" />
            </flux:field>

            <div class="flex items-center gap-4">
                <flux:button type="submit" variant="primary">
                    {{ __('Save') }}
                </flux:button>

                <x-action-message on="saved">
                    <flux:text class="text-green-600">{{ __('Saved.') }}</flux:text>
                </x-action-message>
            </div>
        </form>
    </div>
</div>
