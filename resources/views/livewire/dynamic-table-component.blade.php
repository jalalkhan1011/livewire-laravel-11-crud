<div class="container mt-lg-5">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h4>Dynamic table</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                        <tr>
                            <th>{{ __('Item') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Quenity') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>
                                <button wire:click="addItem()" class="btn btn-sm btn-primary">{{ __('Add') }}</button>
                            </th>
                        </tr>
                    </thead>
                    <form>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td><input type="text" wire:model="items.{{ $index }}.item_name"
                                            class="form-control"></td>
                                    <td><input type="number" wire:model="items.{{ $index }}.price"
                                            wire:change="itemUpdated({{ $index }})" class="form-control"></td>
                                    <td><input type="number" wire:model="items.{{ $index }}.qty"
                                            wire:change="itemUpdated({{ $index }})" class="form-control"></td>
                                    <td><input type="number" wire:model="items.{{ $index }}.sub_total"
                                            class="form-control" hidden>{{ $item['sub_total'] }}
                                    </td>
                                    <td><button wire:click="removeItem({{ $index }})"
                                            class="btn btn-sm btn-danger">{{ __('Remove') }}</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">{{ __('Total') }}</td>
                                <td><input type="number" wire:model="total" class="form-control"
                                        hidden>{{ $total }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary btn-sm mt-2"
                        wire:click.prevent="store()">{{ __('Save') }}</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
