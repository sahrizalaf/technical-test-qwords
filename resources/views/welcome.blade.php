<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="GET" action="{{ route('choose-domain') }}">
        @csrf
        <div>
            <x-input-label for="domain" :value="__('Domain')" />
            <x-text-input id="domain" class="block mt-1 w-full" id="domain" type="text" name="domain" :value="old('domain')" required/>
            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-secondary-button id="search" class="ms-3">
                Cari
            </x-secondary-button>
        </div>

        <div id="message"></div>

        <div id="checkoutAction" style="display: none;">
            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="ms-3">
                    Pesan
                </x-primary-button>
            </div>
        </div>
    </form>

    <script>
        const searchButton = document.getElementById('search')

        searchButton.addEventListener('click', async function(){
            const domainInput = document.getElementById('domain')
            const messageElement = document.getElementById('message')
            const checkoutTab = document.getElementById('checkoutAction')
            const baseUrl = "{{ config('app.url') }}"

            try {
                const response = await fetch(`${baseUrl}/api/check?domain=${domainInput.value}`)

                if (response.ok) {
                    const data = await response.json()
                    if(data.status === 'available'){
                        messageElement.innerHTML = "<p class='text-green-600'>Selamat, domain anda tersedia</p>";
                        checkoutTab.style.display = 'block';
                    } else {
                        messageElement.innerHTML = "<p class='text-red-600'>Domain tidak tersedia</p>";
                        checkoutTab.style.display = 'none';
                    }
                } else {
                    console.log(response);
                    console.error('Error:', response.status, response.statusText)
                }
            } catch (error) {
                console.error('Error:', error)
            }
        });
    </script>
</x-guest-layout>
