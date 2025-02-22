<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Add Product') }}</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="name" wire:model="name"
                            placeholder="Enter name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input type="number" class="form-control" id="price" wire:model="price"
                            placeholder="Enter price">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
</div>
