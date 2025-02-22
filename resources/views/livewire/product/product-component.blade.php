<div class="container mt-lg-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Product List') }}</h2>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('messege') }}
                </div>
            @endif

            @if ($updateMode)
                @include('livewire.product.edit')
            @else
                @include('livewire.product.create')
            @endif

            <table class="table table-bordered table-striped mt-5">
                <thead>
                    <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Sku') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->sku ?: '' }}</td>
                            <td>{{ $product->name ?: '' }}</td>
                            <td>{{ $product->price ?: '' }}</td>
                            <td>
                                <button wire:click="edit({{ $product->id }})"
                                    class="btn btn-warning btn-sm text-white">{{ __('Edit') }}</buton>
                                    <button wire:click="delete({{ $product->id }})"
                                        class="btn btn-danger btn-sm text-white">{{ __('Delete') }}</buton>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
