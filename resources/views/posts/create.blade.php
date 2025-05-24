<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4"
                            required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image upload -->
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image Upload</label>
                        <input type="text" class="form-control @error('image_url') is-invalid @enderror"
                            id="image_url" name="image_url" value="{{ old('content') }}">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- Platform selector (multiple) -->
                    <div class="mb-3">
                        <label for="platforms" class="form-label">Platforms</label>
                        <select id="platforms" name="platforms[]"
                            class="form-select @error('platforms') is-invalid @enderror" multiple required>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}">
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
                            min="{{ today() }}"
                            value="{{ old('scheduled_time') }}"
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
                                    {{ old('status') === $statusOption ? 'selected' : '' }}>
                                    {{ ucfirst($statusOption) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Save Post</button>
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
