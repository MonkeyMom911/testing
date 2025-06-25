<!-- resources/views/hrd/applications/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Filter and Search -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <form action="{{ route('hrd.applications.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:gap-4">
                            <div class="w-full md:w-1/5">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Statuses</option>
                                    <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                                    <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Screening</option>
                                    <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="test" {{ request('status') == 'test' ? 'selected' : '' }}>Test</option>
                                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div class="w-full md:w-1/5">
                                <label for="job_vacancy" class="block text-sm font-medium text-gray-700">Job Position</label>
                                <select id="job_vacancy" name="job_vacancy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Positions</option>
                                    @foreach($jobVacancies ?? [] as $id => $title)
                                        <option value="{{ $id }}" {{ request('job_vacancy') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="w-full md:w-2/5">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search Applicant</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Name or email...">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Search
                                    </button>
                                </div>
                            </div>
                            
                            @if(request()->hasAny(['status', 'job_vacancy', 'search']))
                                <div class="w-full flex justify-end items-end mt-4">
                                    <a href="{{ route('hrd.applications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Clear Filters
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Applications Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Step</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($applications as $application)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($application->user->profile_picture)
                                                        <img class="h-10 w-10 rounded-full" src="{{ Storage::url($application->user->profile_picture) }}" alt="{{ $application->user->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                            <span class="text-white font-medium text-sm">
                                                                {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $application->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $application->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $application->jobVacancy->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->jobVacancy->department }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($application->status == 'applied') bg-gray-100 text-gray-800
                                                @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                                @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                                @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                                @elseif($application->status == 'hired') bg-green-100 text-green-800
                                                @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $currentStage = $application->stages()
                                                    ->with(['selectionStage' => function($query) {
                                                        $query->orderBy('sequence', 'asc');
                                                     }])
                                                    ->whereIn('status', ['pending', 'in_progress'])
                                                    ->first();
                                            @endphp
                                            
                                            @if($currentStage)
                                                <div class="flex items-center">
                                                    <span class="mr-2">{{ $currentStage->selectionStage->name }}</span>
                                                    @if($currentStage->scheduled_date)
                                                        <span class="text-xs text-blue-600">
                                                            ({{ $currentStage->scheduled_date->format('M d, Y') }})
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400">No active stages</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('hrd.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View</a>

                                            <div class="relative inline-block text-left ml-2" x-data="{ open: false }">
                                                <button @click="open = !open" type="button" class="text-indigo-600 hover:text-indigo-900">
                                                    Actions
                                                </button>
                                                
                                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                                    <div class="py-1" role="none">
                                                        @if($application->status != 'hired' && $application->status != 'rejected')
                                                            <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="screening">
                                                                <button type="submit" class="text-left w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                    Move to Screening
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="interview">
                                                                <button type="submit" class="text-left w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                    Move to Interview
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="test">
                                                                <button type="submit" class="text-left w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                    Move to Test
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="hired">
                                                                <button type="submit" class="text-left w-full block px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900" role="menuitem">
                                                                    Mark as Hired
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="text-left w-full block px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900" role="menuitem">
                                                                    Reject Application
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No applications found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $applications->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alpine.js is already included via app.js
            // Any additional JavaScript for this page can go here
        });
    </script>
    @endpush
</x-app-layout>