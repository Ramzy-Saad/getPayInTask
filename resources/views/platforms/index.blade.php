<x-app-layout>
   
  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            platforms
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($platforms as $index => $platform)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $platform->name }}</td>
                                <td>{{ $platform->type}}</td>
                                <td>{{ $platform->status?'Active':'InActive'}}</td>
                                <td>
                                    <a href="{{ route('platforms.show',$platform->id) }}"  class="btn btn-sm btn-{{ $platform->status?"danger":"success" }}">
                                        {{ $platform->status?'DeActivate':'Active now'}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if ($platforms->isEmpty())
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
