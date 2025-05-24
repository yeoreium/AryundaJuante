<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Atur Ulang Password')" :description="__('Masukkan password baru Anda di bawah ini')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
            :placeholder="__('email@example.com')"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Konfirmasi Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Konfirmasi Password')"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Atur Ulang Password') }}
            </flux:button>
        </div>
    </form>
</div>
