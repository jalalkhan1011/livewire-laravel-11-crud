<div class="container mt-lg-5">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h2>Post List</h2>
            </div>
            <div class="card-body">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('messege') }}
                    </div>
                @endif
                @if ($updateMode)
                    @include('livewire.update')
                @else
                    @include('livewire.create')
                @endif
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Descripiton</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $post->title ?: '' }}</td>
                                <td>{{ $post->body ?: '' }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
