<div class="modal show fade d-block">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Edit Sale') }}</h5>
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal()"></button>
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
                    <div class="col-md-6"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Sale List') }}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Sku') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Qty') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th><button wire:click="addItem()"
                                                    class="btn btn-sm btn-primary">{{ __('Add') }}</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($saleItems as $index => $saleItem)
                                            <tr>
                                                <td>
                                                    <select class="form-control"
                                                        wire:model="saleItems.{{ $index }}.product_id"
                                                        wire:change="productUpdate({{ $index }})" required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select product') }}</option>
                                                        @foreach ($products as $key => $product)
                                                            <option value="{{ $key }}">{{ $product }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control"
                                                        wire:model="saleItems.{{ $index }}.purchase_product_item_id"
                                                        wire:change="skuUpdate({{ $index }})" required>
                                                        <option value="" disabled selected>
                                                            {{ __('Select product') }}</option>
                                                        @foreach ($saleItem['productsSkus'] ?? [] as $key => $productsSku)
                                                            <option value="{{ $key }}">
                                                                {{ $productsSku }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input class="form-control"
                                                        wire:model="saleItems.{{ $index }}.price"
                                                        wire:change="skuUpdate({{ $index }})" readonly></td>
                                                <td><input class="form-control"
                                                        wire:model="saleItems.{{ $index }}.qty"
                                                        wire:change="skuUpdate({{ $index }})"></td>
                                                <td><input class="form-control"
                                                        wire:model="saleItems.{{ $index }}.individual_total"
                                                        readonly hidden>{{ $saleItem['individual_total'] }}</td>
                                                <td><button wire:click="removeItem({{ $index }})"
                                                        class="btn btn-sm btn-danger">{{ __('Delete') }}</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end">{{ __('Sub Total') }}</td>
                                            <td><input type="number" wire:model="subTotal" class="form-control" hidden
                                                    required>{{ $subTotal }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">{{ __('Discount') }}</td>
                                            <td><input type="number" wire:model="discount"
                                                    wire:change="calculateTotal()" class="form-control"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">{{ __('Total') }}</td>
                                            <td>
                                                <input type="number" wire:model="total" class="form-control" hidden
                                                    required>{{ $total }}
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
                <button type="button" class="btn btn-secondary" wire:click="closeModal()">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary"
                    wire:click.prevent="store()">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
