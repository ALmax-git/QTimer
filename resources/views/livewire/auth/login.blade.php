<section>
    <div class="form-box">
        <div class="form-value">
            <form>
                @csrf
                <div class="inputbox relative mb-3 w-full" style="border: none !important;">
                    <span style="color: red;">{{ $user_log }}</span>
                </div>
                <div class="relative mb-3 w-full">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" style="display: hidden;" wire:model='email' hidden />
                </div>
                <div class="inputbox relative mb-3 w-full">
                    <input type="text" value="{{ old('email') }}" wire:change='chech_for_email' required autocomplete="email" autofocus wire:model.live='username_email_or_phone' />
                    <label for="email">{{ __('ID Number') }}</label>
                    @error('email')
                        <div class="text-red-500">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                </div>

                <div class="inputbox relative mb-3 w-full">
                    <input id="password" name="password" type="password" required autocomplete="current-password" />
                    <label for="password">{{ __('Password') }}</label>
                    @error('password')
                        <span class="text-red-500">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <br>
                <div class="mt-6 text-center">
                    <button wire:click="_login" {{ $username_email_or_phone_is_valid ? '' : 'disabled' }}>
                        {{ $username_email_or_phone_is_valid ? __('Login') : '...' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
