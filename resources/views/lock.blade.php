@extends('nova-lock-screen::layout')

@section('content')
    <div class="p-8 max-w-sm mx-auto text-center text-white lock-form radius-16 {{ $errors->any() ? 'shake' : '' }}">

        <form method="post" action="">
            @csrf
            <h4 class="text-2xl text-center font-normal mb-6 text-90">
                Hi {{ $username }}
            </h4>

            <p>Enter your password to continue</p>

            <div class="mb-6 mt-3">
                <input autofocus
                    class="form-control form-input w-full text-center opacity-75 text-black border-none h-12 radius-16 bg-gray-300"
                    id="password" type="password" ref="password" name="password" required />
                <small class="mt-2 text-red-300">{{ $errors->first() }}</small>
            </div>

            <button class="w-full flex justify-center radius-16 py-3 bg-black mb-3" type="submit">
                <span> Unlock <i type="arrow-right"></i> </span>
            </button>
        </form>

        <form id="logout-form" method="post" action="{{ $logout }}">
            @csrf
            <div class="my-2 cursor-pointer" onclick="document.getElementById('logout-form').submit();">Logout</div>
        </form>
    </div>
@endsection
