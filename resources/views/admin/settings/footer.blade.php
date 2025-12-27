<x-admin-layout :breadcrumbs="[['name' => 'Configuración'], ['name' => 'Footer']]">
    <div class="max-w-4xl">
        <div class="rounded-lg border border-slate-200/70 bg-white p-6 shadow-sm">
            <h1 class="text-lg font-semibold text-slate-800">Footer</h1>

            <form class="mt-6 space-y-6" method="POST" action="{{ route('admin.settings.footer.update') }}"
                enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="footer_logo" class="block text-sm font-medium text-slate-700">Logo</label>
                    <input id="footer_logo" name="footer_logo" type="file" accept="image/*"
                        class="mt-2 block w-full rounded-md border border-slate-300 bg-white text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
