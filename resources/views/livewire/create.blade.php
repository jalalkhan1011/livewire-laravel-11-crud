<form>
    <div class="form-group">
        <label for="tittle">Title</label>
        <input type="text" class="form-control" id="title" wire:model="title" placeholder="Enter Title">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="body">Description</label>
        <textarea class="form-control" id="body" wire:model="body" placeholder="Enter Body"></textarea>
        @error('body')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary btn-sm mt-2" wire:click.prevent="store()">Save</button>
</form>
