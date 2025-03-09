<div class="container mt-lg-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Product Sale List') }}</h2>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-primary btn-sm" wire:click="create()">{{ __('Add') }}</button>
                </div>
            </div>
            <table class="table table-bordered table-striped mt-2">
                <thead>
                    <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Sku') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Sub Total') }}</th>
                        <th>{{ __('Discount') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $sale->sku ?: '' }}</td>
                            <td>{{ $sale->date ?: '' }}</td>
                            <td>{{ $sale->sub_total ?: 0.0 }}</td>
                            <td>{{ $sale->discount ?: 0.0 }}</td>
                            <td>{{ $sale->grand_total ?: 0.0 }}</td>
                            <td>
                                <button wire:click="edit({{ $sale->id }})"
                                    class="btn btn-warning btn-sm text-white">
                                    {{ __('Edit') }}</buton>
                                    <button wire:click="delete({{ $sale->id }})"
                                        class="btn btn-danger btn-sm text-white">{{ __('Delete') }}</buton>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            @if ($isCreateModalOpen)
                @include('livewire.product.sale.create')
            @endif
            @if ($isEditModalOpen)
            @endif
        </div>
    </div>
</div>
