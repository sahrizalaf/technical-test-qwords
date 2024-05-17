<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-between">
        <span>No. Invoice: {{ $order->id }}</span>
        <h3 class="align-items-end font-extrabold text-red-600">UNPAID</h3>
    </div>

    <div class="mt-4">
        <div>Nama: {{ $order->owner->name }}</div>
        <div>Email: {{ $order->owner->email }}</div>
    </div>

    <div class="mt-4">
        <table class="border-collapse border border-black-500 border-spacing-2" cellpadding="8">
            <tr class="border border-black-500">
                <th class="border border-black-500">No</th>
                <th class="border border-black-500">Deskripsi</th>
                <th class="border border-black-500">Total</th>
            </tr>
            <tr class="border border-black-500">
                <td class="border border-black-500">1</td>
                <td class="border border-black-500">Pembelian domain {{ $order->domain }}</td>
                <td class="border border-black-500">Rp. {{ number_format($order->duration * $price, 0, '.', '.')}}</td>
            </tr>
        </table>
    </div>

    <div class="mt-4">
        <p>Silahkan bayar di no rekening berikut ini <b>663721667321</b></p>
    </div>


</x-guest-layout>
