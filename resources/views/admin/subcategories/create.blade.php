<x-admin-layout :breadcrumbs="[
    [
        'name' => __('ui.dashboard'),
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Subcategorías',
        'route' => route('admin.subcategories.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">

 

    @livewire('admin.subcategories.subcategory-create')
   

</x-admin-layout>
