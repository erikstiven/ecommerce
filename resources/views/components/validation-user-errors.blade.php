@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-white">
            {{ __('¡Ups! Algo salió mal.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-white space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
