<x-app-layout>
   
  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('posts.create') }}"
                class="btn btn-sm btn-primary">Create</a>
                <div class="dropdown mb-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Filter by Status
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                        <li><a class="dropdown-item" href="{{ route('posts.index') }}">All</a></li>
                        <li><a class="dropdown-item" href="{{ route('posts.index', ['status' => 'draft']) }}">Draft</a></li>
                        <li><a class="dropdown-item" href="{{ route('posts.index', ['status' => 'scheduled']) }}">Scheduled</a></li>
                        <li><a class="dropdown-item" href="{{ route('posts.index', ['status' => 'published']) }}">Published</a></li>
                    </ul>
                </div>
                
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Scheduled Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $index => $post)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $post->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($post->scheduled_time)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if ($post->status === 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @elseif($post->status === 'scheduled')
                                        <span class="badge bg-warning text-dark">Scheduled</span>
                                    @elseif($post->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($post->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($posts->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No posts found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
