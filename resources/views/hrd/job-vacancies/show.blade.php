<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Vacancy Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('hrd.job-vacancies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                    Back to List
                </a>
                <a href="{{ route('hrd.job-vacancies.edit', $jobVacancy) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700">
                    Edit Vacancy
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $jobVacancy->title }}</h3>
                        <p class="text-lg text-gray-600">{{ $jobVacancy->department }}</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $jobVacancy->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($jobVacancy->status) }}
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><strong class="block text-gray-500">Location</strong> {{ $jobVacancy->location }}</div>
                    <div><strong class="block text-gray-500">Type</strong> {{ ucfirst($jobVacancy->employment_type) }}</div>
                    <div><strong class="block text-gray-500">Quota</strong> {{ $jobVacancy->quota }}</div>
                    <div><strong class="block text-gray-500">Salary</strong> {{ $jobVacancy->salary_range ?? 'Not specified' }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div x-data="{ tab: 'description' }">
                    <div class="border-b border-gray-200"><nav class="-mb-px flex space-x-8"><a @click.prevent="tab = 'description'" :class="{ 'border-blue-500 text-blue-600': tab === 'description' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer">Description</a><a @click.prevent="tab = 'requirements'" :class="{ 'border-blue-500 text-blue-600': tab === 'requirements' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer text-gray-500 hover:text-gray-700">Requirements</a><a @click.prevent="tab = 'responsibilities'" :class="{ 'border-blue-500 text-blue-600': tab === 'responsibilities' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer text-gray-500 hover:text-gray-700">Responsibilities</a></nav></div>
                    <div x-show="tab === 'description'" class="mt-6 prose max-w-none">{{ $jobVacancy->description }}</div>
                    <div x-show="tab === 'requirements'" class="mt-6 prose max-w-none" style="display:none;">{{ $jobVacancy->requirements }}</div>
                    <div x-show="tab === 'responsibilities'" class="mt-6 prose max-w-none" style="display:none;">{{ $jobVacancy->responsibilities }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                 <h3 class="text-lg font-medium text-gray-900 mb-4">Selection Stages</h3>
                 <ul class="list-decimal list-inside space-y-2">
                    @forelse($jobVacancy->selectionStages->sortBy('sequence') as $stage)
                        <li><strong class="font-semibold">{{ $stage->name }}:</strong> {{ $stage->description }}</li>
                    @empty
                        <li class="list-none text-gray-500">No selection stages defined for this vacancy.</li>
                    @endforelse
                 </ul>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Applications Received ({{ $applications->total() }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($applications as $application)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div><div class="text-sm text-gray-500">{{ $application->user->email }}</div></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ ucfirst($application->status) }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"><a href="{{ route('hrd.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View Details</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No applications received yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $applications->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>