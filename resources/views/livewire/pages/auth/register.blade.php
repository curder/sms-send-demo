<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Rules\ChinesePhoneNumber;
use App\Enums\EventTypeEnum;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $phone = '';
    public string $verify_code = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatedPhone(): void
    {
        $this->dispatch(EventTypeEnum::PhoneUpdated->value, ['phone' => $this->phone]);

        $this->validateOnly('phone', $this->rules());
    }

    #[\Livewire\Attributes\On(EventTypeEnum::SmsSendFailed->value)]
    public function smsSendFailed($event): void
    {
        $this->resetValidation('phone');
        $this->addError('phone', $event['message']);
    }

    #[\Livewire\Attributes\On(EventTypeEnum::SmsSendSuccess->value)]
    public function smsSendSuccess(): void
    {
        $this->resetValidation('phone');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate();

        // Verify that the verification code is correct
        if (!Sms::checkCode($this->phone, $this->verify_code)) {
            $this->addError('verify_code', __('Verify Code Invalid'));
            return;
        }

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', new ChinesePhoneNumber(), "unique:users,phone,{$this->phone}"],
//            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone number')"/>
            <x-text-input wire:model.live.debounce="phone" id="phone" class="block mt-1 w-full" type="text"
                          name="phone" required
                          autocomplete="phone"/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
        </div>

        <!-- Verify Code -->
        <div class="mt-4">
            <x-input-label for="verify_code" :value="__('Verify Code')"/>
            <div class="flex items-center space-x-4">
                <x-text-input wire:model="verify_code" id="verify_code" class="block mt-1 w-[17rem]" type="text"
                              name="verify_code" required
                              autocomplete="verify_code"/>
                <livewire:sms-send :type="\App\Enums\SmsSendTypeEnum::Register"/>
            </div>
            <x-input-error :messages="$errors->get('verify_code')" class="mt-2"/>
        </div>

{{--        <!-- Email Address -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="email" :value="__('Email')"/>--}}
{{--            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required--}}
{{--                          autocomplete="username"/>--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2"/>--}}
{{--        </div>--}}

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
