<div class="container mt-lg-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Product Purchase List') }}</h2>
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
                    <button class="btn btn-primary btn-sm" wire:click="create()" data-bs-toggle="modal" data-bs-target="#staticBackdrop">{{ __('Add') }}</button>
                </div>
            </div>
            <table class="table table-bordered table-striped mt-2">
                <thead>
                    <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Sku') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($productPurchases as $productPurchase)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $productPurchase->sku ?: '' }}</td>
                            <td>{{ $productPurchase->created_at ?: '' }}</td>
                            <td>{{ $productPurchase->total ?: '' }}</td>
                            <td>
                                <button wire:click="edit({{ $productPurchase->id }})"
                                    class="btn btn-warning btn-sm text-white">{{ __('Edit') }}</buton>
                                    <button wire:click="delete({{ $productPurchase->id }})"
                                        class="btn btn-danger btn-sm text-white">{{ __('Delete') }}</buton>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          

            <!-- Modal -->
            @if ($isCreateModalOpen)
                @include('livewire.product.purchase.create')
            @endif
            @if ($isEditModalOpen)
                @include('livewire.product.purchase.edit')
            @endif
        </div>
    </div>
</div>
