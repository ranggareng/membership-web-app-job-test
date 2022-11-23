@section('title', 'Verify your email address')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>

        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
            Menunggu Pembayaran
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            @if (session('resent'))
                <div class="flex items-center px-4 py-3 mb-6 text-sm text-white bg-green-500 rounded shadow" role="alert">
                    <svg class="w-4 h-4 mr-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>

                    <p>A fresh verification link has been sent to your email address.</p>
                </div>
            @endif

            <div class="text-sm text-gray-700">
                <p>Silahkan lakukan pembayaran untuk mengaktifkan akun membership Anda, pembayaran dapat dilakukan dengan cara transfer ke nomor rekening dibawah ini:</p>
                <h3 class="my-5 p-5 bg-green-400">Bank BCA No Rek <b>123-456-789</b> A.N Mochamad Rangga</h3>
                <p class="mt-3">
                    Jika sudah melakukan pembayaran, silahkan lakukan konfirmasi pembayaran dengan cara <a href="{{ route('membership.payment.confirmation') }}" class="text-indigo-700 cursor-pointer hover:text-indigo-600 focus:outline-none focus:underline transition ease-in-out duration-150">Klik Disini</a>.
                </p>
            </div>
        </div>
    </div>
</div>
