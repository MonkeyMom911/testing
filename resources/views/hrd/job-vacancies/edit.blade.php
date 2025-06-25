<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}: {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('hrd.job-vacancies.update', $jobVacancy->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Job Details Section (sama seperti create, tapi dengan value) --}}
                        <div class="p-4 border rounded-lg">
                            <h3 class="text-lg font-medium mb-4 text-gray-900">Job Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="title" :value="__('Job Title *')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $jobVacancy->title)" required />
                                </div>
                                <div>
                                    <x-input-label for="department" :value="__('Department *')" />
                                    <x-text-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department', $jobVacancy->department)" required />
                                </div>
                                <div>
                                    <x-input-label for="location" :value="__('Location *')" />
                                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $jobVacancy->location)" required />
                                </div>
                                <div>
                                    <x-input-label for="employment_type" :value="__('Employment Type *')" />
                                    <select id="employment_type" name="employment_type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="full-time" {{ old('employment_type', $jobVacancy->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="part-time" {{ old('employment_type', $jobVacancy->employment_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="contract" {{ old('employment_type', $jobVacancy->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="internship" {{ old('employment_type', $jobVacancy->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="salary_range" :value="__('Salary Range (Optional)')" />
                                    <x-text-input id="salary_range" class="block mt-1 w-full" type="text" name="salary_range" :value="old('salary_range', $jobVacancy->salary_range)" />
                                </div>
                                <div>
                                    <x-input-label for="quota" :value="__('Quota *')" />
                                    <x-text-input id="quota" class="block mt-1 w-full" type="number" name="quota" :value="old('quota', $jobVacancy->quota)" required min="1" />
                                </div>
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="active" {{ old('status', $jobVacancy->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="closed" {{ old('status', $jobVacancy->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="description" :value="__('Job Description *')" />
                                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $jobVacancy->description) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="requirements" :value="__('Requirements *')" />
                                    <textarea id="requirements" name="requirements" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('requirements', $jobVacancy->requirements) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="responsibilities" :value="__('Responsibilities *')" />
                                    <textarea id="responsibilities" name="responsibilities" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('responsibilities', $jobVacancy->responsibilities) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('hrd.job-vacancies.show', $jobVacancy->id) }}" class="text-gray-600">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Job Vacancy') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>