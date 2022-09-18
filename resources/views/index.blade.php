<x-volt-app title="{{ request()->route()->getName() }}">
    <div
        id="crudIndex"
        data-base-url="{{ config('api.url') }}/{{ \Illuminate\Support\Str::of(request()->route()->getName())->before('.') }}"
        data-title="{{ request()->route()->getName() }}"
        data-description=""
    >
    </div>
</x-volt-app>
