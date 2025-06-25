<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Manage Your Job Vacancies') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Create and manage job postings for your department.</p>
            </div>
            <a href="{{ route('hrd.job-vacancies.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create New Job
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <form action="{{ route('hrd.job-vacancies.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:gap-4">
                        <div class="w-full md:w-1/3">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="w-full md:w-2/3">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search job title..." class="block w-full rounded-lg pr-10 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($jobVacancies as $jobVacancy)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300 group">
                        <div class="p-6 flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-secondary-800 group-hover:text-primary-600 transition-colors duration-300">{{ $jobVacancy->title }}</h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($jobVacancy->status == 'active') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($jobVacancy->status) }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-secondary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    {{ $jobVacancy->department }}
                                </div>
                                <div class="mt-1 flex items-center text-sm text-secondary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $jobVacancy->location }}
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-secondary-100 flex items-center justify-between">
                                <a href="{{ route('hrd.applications.index', ['job_vacancy' => $jobVacancy->id]) }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors duration-300">
                                    {{ $jobVacancy->applications_count }} {{ Str::plural('Application', $jobVacancy->applications_count) }}
                                </a>
                                <div class="flex space-x-3">
                                    <a href="{{ route('hrd.job-vacancies.show', $jobVacancy) }}" class="text-secondary-500 hover:text-secondary-700">View</a>
                                    <a href="{{ route('hrd.job-vacancies.edit', $jobVacancy) }}" class="text-secondary-500 hover:text-secondary-700">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-sm p-6 text-center">
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Job Vacancies Found</h3>
                        <p class="mt-1 text-sm text-gray-500">You have not created any job vacancies yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('hrd.job-vacancies.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                Create Your First Job
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $jobVacancies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>