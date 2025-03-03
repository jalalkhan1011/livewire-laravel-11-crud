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
                    <button class="btn btn-primary btn-sm" wire:click="create()">{{ __('Add') }}</button>
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
                                    class="btn btn-warning btn-sm text-white">
                                  {{ __('Edit') }}</buton>
                                    <button wire:click="delete({{ $productPurchase->id }})"
                                        class="btn btn-danger btn-sm text-white">{{ __('Delete') }}</buton>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            @if ($isCreateModalOpen)
                <div class="modal fade show d-block">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">
                                    {{ __('Creat product purchase') }}</h5>
                                <button type="button" class="btn-close" wire:click="closeModal()"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">{{ __('Date') }}<span class="text-danger">
                                                    *</span></label>
                                            <input type="date" class="form-control" id="date" wire:model="date"
                                                placeholder="Enter date">
                                            @error('date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>{{ __('Purchase products') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Product') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>{{ __('Qty') }}</th>
                                                            <th>{{ __('Amount') }}</th>
                                                            <th><button wire:click="addItem()"
                                                                    class="btn btn-primary btn-sm">{{ __('Add') }}</button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <select
                                                                        wire:model="items.{{ $index }}.product_id"
                                                                        wire:change="productUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                        <option value="" disabled selected>
                                                                            {{ __('Select Product') }}</option>
                                                                        @foreach ($products as $key => $product)
                                                                            <option value="{{ $key }}">
                                                                                {{ $product }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.price"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" readonly required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.qty"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.individual_total"
                                                                        class="form-control"
                                                                        hidden required>{{ $item['individual_total'] }}
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        wire:click="removeItem({{ $index }})"
                                                                        class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end">{{ __('Total') }}
                                                            </td>
                                                            <td><input type="number" wire:model="grandtotal"
                                                                    class="form-control" hidden required>{{ $grandtotal }}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal()">{{ __('Close') }}</button>
                                <button type="button" class="btn btn-primary"
                                    wire:click.prevent="store()">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($isEditModalOpen)
                <div class="modal fade show d-block">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">
                                    {{ __('Edit product purchase') }}</h5>
                                <button type="button" class="btn-close" wire:click="closeModal()"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">{{ __('Date') }}<span class="text-danger">
                                                    *</span></label>
                                            <input type="date" class="form-control" id="date" wire:model="date"
                                                placeholder="Enter date">
                                            @error('date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>{{ __('Purchase products') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Product') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>{{ __('Qty') }}</th>
                                                            <th>{{ __('Amount') }}</th>
                                                            <th><button wire:click="addItem()"
                                                                    class="btn btn-primary btn-sm">{{ __('Add') }}</button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <select
                                                                        wire:model="items.{{ $index }}.product_id"
                                                                        wire:change="productUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                        <option value="" disabled selected>
                                                                            {{ __('Select Product') }}</option>
                                                                        @foreach ($products as $key => $product)
                                                                            <option value="{{ $key }}">
                                                                                {{ $product }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.price"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" readonly required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.qty"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.individual_total"
                                                                        class="form-control"
                                                                        hidden required>{{ $item['individual_total'] }}
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        wire:click="removeItem({{ $index }})"
                                                                        class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end">{{ __('Total') }}
                                                            </td>
                                                            <td><input type="number" wire:model="grandtotal"
                                                                    class="form-control" hidden required>{{ $grandtotal }}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal()">{{ __('Close') }}</button>
                                <button type="button" class="btn btn-primary"
                                    wire:click.prevent="update()">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- @if ($isModalOpen)
                <div class="modal fade show d-block">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">
                                    {{ __('Creat/Edit product purchase') }}</h5>
                                <button type="button" class="btn-close" wire:click="closeModal()"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">{{ __('Date') }}<span class="text-danger">
                                                    *</span></label>
                                            <input type="date" class="form-control" id="date" wire:model="date"
                                                placeholder="Enter date">
                                            @error('date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>{{ __('Purchase products') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Product') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>{{ __('Qty') }}</th>
                                                            <th>{{ __('Amount') }}</th>
                                                            <th><button wire:click="addItem()"
                                                                    class="btn btn-primary btn-sm">{{ __('Add') }}</button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <select
                                                                        wire:model="items.{{ $index }}.product_id"
                                                                        wire:change="productUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                        <option value="" disabled selected>
                                                                            {{ __('Select Product') }}</option>
                                                                        @foreach ($products as $key => $product)
                                                                            <option value="{{ $key }}">
                                                                                {{ $product }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.price"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" readonly required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.qty"
                                                                        wire:change="itemUpdate({{ $index }})"
                                                                        class="form-control" required>
                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        wire:model="items.{{ $index }}.individual_total"
                                                                        class="form-control"
                                                                        hidden required>{{ $item['individual_total'] }}
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        wire:click="removeItem({{ $index }})"
                                                                        class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end">{{ __('Total') }}
                                                            </td>
                                                            <td><input type="number" wire:model="grandtotal"
                                                                    class="form-control" hidden required>{{ $grandtotal }}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal()">{{ __('Close') }}</button>
                                <button type="button" class="btn btn-primary"
                                    wire:click.prevent="store()">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
        </div>
    </div>
</div>
