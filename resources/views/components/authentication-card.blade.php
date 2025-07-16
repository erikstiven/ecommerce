@props(['width' => 'sm:max-w-md'])

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-gray-900 via-indigo-900 to-black text-white">

    {{-- Logo --}}
    <div>
        {{ $logo }}
    </div>

   <div class="w-full {{ $width }} mt-6 px-8 py-8 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 shadow-2xl rounded-xl border border-indigo-600 text-white">
    {{ $slot }}
</div>


</div>
