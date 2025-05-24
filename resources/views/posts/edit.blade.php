<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            edit Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4"
                            required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image upload -->
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image Upload</label>
                        <input type="text" class="form-control @error('image_url') is-invalid @enderror"
                            id="image_url" name="image_url" value="{{ old('content', $post->image_url) }}">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($post->image_url)
                            <div class="mt-2">
                                <img src="{{ asset($post->image_url) }}" alt="Current Image" style="max-height: 150px;">
                            </div>
                        @endif
                    </div>

                    <!-- Platform selector (multiple) -->
                    <div class="mb-3">
                        <label for="platforms" class="form-label">Platforms</label>
                        <select id="platforms" name="platforms[]"
                            class="form-select @error('platforms') is-invalid @enderror" multiple required>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}"
                                    {{ in_array($platform->id, old('platforms', $post->platforms->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ ucfirst($platform->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('platforms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Scheduled time -->
                    <div class="mb-3">
                        <label for="scheduled_time" class="form-label">Scheduled Time</label>
                        <input type="datetime-local" class="form-control @error('scheduled_time') is-invalid @enderror"
                            id="scheduled_time" name="scheduled_time"
                            value="{{ old('scheduled_time', \Carbon\Carbon::parse($post->scheduled_time)->format('Y-m-d\TH:i')) }}"
                            required>
                        @error('scheduled_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            @foreach (['draft', 'scheduled', 'published'] as $statusOption)
                                <option value="{{ $statusOption }}"
                                    {{ old('status', $post->status) === $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst($statusOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>

        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#platforms').select2({
                placeholder: "Select platforms",
                allowClear: true,
                width: '100%' // important for Bootstrap form-control width
            });
        });
    </script>
    @endpush


</x-app-layout>
