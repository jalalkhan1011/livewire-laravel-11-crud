<div>
    <button class="btn btn-primary" wire:click="create()">Create Post</button>

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>
                        <button class="btn btn-info" wire:click="edit({{ $post->id }})">Edit</button>
                        <button class="btn btn-danger" wire:click="delete({{ $post->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($isOpen)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create/Edit Post</h5>
                        <button type="button" class="close" wire:click="closeModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control mb-2" placeholder="Title" wire:model="title">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror

                        <textarea class="form-control mb-2" placeholder="Content" wire:model="content"></textarea>
                        @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="store()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
