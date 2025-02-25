<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Product Purcahse Create') }}</h5>
                <button wire:click="closeModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">{{ __('Date') }}<span class="text-danger"> *</span></label>
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
                                                    class="btn btn-primary btn-sm">{{ __('Add') }}</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $index => $item)
                                            <tr>
                                                <td>
                                                    <select wire:model="items.{{ $index }}.product_id"
                                                        wire:change="productUpdate({{ $index }})"
                                                        class="form-control">
                                                        <option value="" disabled selected>
                                                            {{ __('Select Product') }}</option>
                                                        @foreach ($products as $key => $product)
                                                            <option value="{{ $key }}">{{ $product }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" wire:model="items.{{ $index }}.price"
                                                        wire:change="itemUpdate({{ $index }})"
                                                        class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        wire:model="items.{{ $index }}.qty"
                                                        wire:change="itemUpdate({{ $index }})"
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        wire:model="items.{{ $index }}.individual_total"
                                                        class="form-control" hidden>{{ $item['individual_total'] }}
                                                </td>
                                                <td>
                                                    <button wire:click="removeItem({{ $index }})"
                                                        class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">{{ __('Total') }}</td>
                                            <td><input type="number" wire:model="grandtotal" class="form-control"
                                                    hidden>{{ $grandtotal }}</td>
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
                <button type="submit" class="btn btn-primary"
                    wire:click.prevent="store()">{{ __('Save') }}</button>
                <button wire:click="closeModal()" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
