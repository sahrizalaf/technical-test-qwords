<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('checkout') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <div class="flex">
                <span class="me-4 align-middle py-2">{{ $selectedDomain }}</span>
                <input type="hidden" name="domain" value="{{ $selectedDomain }}">
                <select class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="duration" id="duration" required>
                    <option value="1">1 Tahun</option>
                    <option value="2">2 Tahun</option>
                    <option value="3">3 Tahun</option>
                </select>
                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
            </div>
            <div class="flex justify-end mt-4" id="price-label">
                <span class="outline-2 outline-black">Total Rp. {{ number_format($price, 0, ',', '.') }}</span>
            </div>
        </div>

        @guest
            <div>
                <h3 class="mb-4">Daftar Akun</h3>
                <div class="mb-2">
                    <x-input-label for="name" :value="__('Nama')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-2">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-2">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>
        @endguest

        @auth
            <div class="mt-4">
                <h3>Data Customer</h3>
                <div class="flex">
                    <span class="me-6">Nama:</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="flex mt-2">
                    <span class="me-6">Email:</span>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
        @endauth

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                Checkout
            </x-primary-button>
        </div>

    </form>

    <script>
        const selectDuration = document.getElementById('duration');
        const priceLabel = document.getElementById('price-label');
        selectDuration.addEventListener('change', function(){
            const price = {{ $price }};
            const total = parseInt(selectDuration.value) * parseInt(price);
            priceLabel.innerHTML = `<span class='outline-2 outline-black'>Total Rp. ${total.toLocaleString('id')}</span>`;
        })
    </script>

</x-guest-layout>
