<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="logged-in p-6">You're logged in</p>
                <div class="p-6 bg-white">
                    <div class="grid grid-cols-1 border border-gray-200 divide-y divide-slate-200">
                        <p class="block text-gray-700 p-6 font-bold bg-gray-100">Add New Country</p>
                        <!-- Create State Form -->
                        <form action="{{ route('states.store') }}" method="POST">
                            @csrf
                            <div class="mt-4 px-6">
                                <label for="state-name-input" class="block text-gray-700 font-bold mb-2">Name</label>
                                <input type="text" id="state-name-input" name="name" required class="w-full py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="mt-4 px-6">
                                <label for="state-iso-input" class="block text-gray-700 font-bold mb-2">ISO</label>
                                <input type="text" id="state-iso-input" name="iso" required class="w-full py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="p-6 w-1 flex items-end">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Create State</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- List of States -->
            <div class="p-6 bg-white divide-y divide-slate-200">
                <table class="table-auto w-full border-separate border-spacing-2 border border-slate-400">
                    <thead class="border-separate border-spacing-2 border border-slate-400">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>ISO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $index => $state)
                        <tr class="border-separate border-spacing-2 border border-slate-400">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                <span class="state-name">{{ ucfirst($state->name) }}</span>
                                <input type="text" class="hidden state-name-input max-w-prose" required value="{{ ucfirst($state->name) }}" required>
                            </td>
                            <td class="text-center">
                                <span class="state-iso">{{ strtoupper($state->iso) }}</span>
                                <input type="text" class="hidden state-iso-input max-w-prose" required value="{{ strtoupper($state->iso) }}" required>
                            </td>
                            <td class="text-center">
                                <button class="edit-button text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-state-id="{{ $state->id }}">Edit</button>
                                <button class="hidden save-button text-sm bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-state-id="{{ $state->id }}">Save</button>
                                <button class="delete-button text-sm bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-state-id="{{ $state->id }}">Delete</button>
                                <button class="hidden cancel-button text-sm bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>