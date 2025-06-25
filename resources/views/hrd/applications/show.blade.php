<!-- resources/views/hrd/applications/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Application Details') }}
            </h2>
            <a href="{{ route('hrd.applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Applications
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Application Header -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $application->jobVacancy->title }}</h3>
                            <div class="mt-2 flex items-center">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($application->status == 'applied') bg-gray-100 text-gray-800
                                    @elseif($application->status == 'screening') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                    @elseif($application->status == 'test') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'hired') bg-green-100 text-green-800
                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                <span class="ml-2 text-sm text-gray-500">
                                    Applied: {{ $application->created_at->format('M d, Y H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <!-- Status Update Dropdown -->
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Status
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none max-h-60 overflow-y-auto z-10" style="display: none;">
                                    <form action="{{ route('hrd.applications.update-status', $application) }}" method="POST" x-ref="updateForm" class="py-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" x-ref="statusInput">

                                        <button type="button" @click="$refs.statusInput.value = 'screening'; $refs.updateForm.submit()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Move to Screening</button>
                                        <button type="button" @click="$refs.statusInput.value = 'interview'; $refs.updateForm.submit()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Move to Interview</button>
                                        <button type="button" @click="$refs.statusInput.value = 'test'; $refs.updateForm.submit()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Move to Test</button>
                                        <button type="button" @click="$refs.statusInput.value = 'hired'; $refs.updateForm.submit()" class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100">Mark as Hired</button>
                                        <button type="button" @click="$refs.statusInput.value = 'rejected'; $refs.updateForm.submit()" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100">Reject Application</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Applicant Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if($application->user->profile_picture)
                                    <img class="h-16 w-16 rounded-full" src="{{ Storage::url($application->user->profile_picture) }}" alt="{{ $application->user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium text-xl">
                                            {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                                @if($application->user->phone_number)
                                    <p class="text-sm text-gray-600">{{ $application->user->phone_number }}</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($application->user->profile)
                            <div class="mt-4 space-y-2">
                                @if($application->user->profile->address)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Address</h4>
                                        <p class="text-sm text-gray-900">
                                            {{ $application->user->profile->address }}, 
                                            {{ $application->user->profile->city }}, 
                                            {{ $application->user->profile->province }} 
                                            {{ $application->user->profile->postal_code }}
                                        </p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->date_of_birth)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Date of Birth</h4>
                                        <p class="text-sm text-gray-900">{{ $application->user->profile->date_of_birth->format('M d, Y') }}</p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->gender)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Gender</h4>
                                        <p class="text-sm text-gray-900">{{ ucfirst($application->user->profile->gender) }}</p>
                                    </div>
                                @endif
                                
                                @if($application->user->profile->bio)
                                    <div>
                                        <h4 class="text-xs font-medium text-gray-500 uppercase">Bio</h4>
                                        <p class="text-sm text-gray-900">{{ $application->user->profile->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <a href="mailto:{{ $application->user->email }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email Applicant
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Information</h3>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Position</h4>
                                <p class="text-sm font-semibold text-gray-900">{{ $application->jobVacancy->title }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Department</h4>
                                <p class="text-sm text-gray-900">{{ $application->jobVacancy->department }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Location</h4>
                                <p class="text-sm text-gray-900">{{ $application->jobVacancy->location }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Employment Type</h4>
                                <p class="text-sm text-gray-900">{{ ucfirst($application->jobVacancy->employment_type) }}</p>
                            </div>
                            
                            @if($application->jobVacancy->salary_range)
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500 uppercase">Salary Range</h4>
                                    <p class="text-sm text-gray-900">{{ $application->jobVacancy->salary_range }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 uppercase">Expected Salary</h4>
                                <p class="text-sm text-gray-900">Rp {{ number_format($application->expected_salary, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('jobs.show', $application->jobVacancy->slug) }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Job Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Selection Process -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Selection Progress</h3>
                        
                        <div class="relative">
                            @foreach($application->stages as $index => $stage)
                                <div class="relative flex items-start group @if(!$loop->last) pb-10 @endif">
                                    <div class="flex items-center h-9 @if(!$loop->last) after:content-[''] after:absolute after:left-4 after:top-9 after:bottom-0 after:w-0.5 after:bg-gray-200 @endif">
                                        <span class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full 
                                            @if($stage->status == 'passed') bg-green-500 
                                            @elseif($stage->status == 'failed') bg-red-500 
                                            @elseif($stage->status == 'in_progress') bg-yellow-500 
                                            @else bg-gray-300 
                                            @endif">
                                            @if($stage->status == 'passed')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @elseif($stage->status == 'failed')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @else
                                                <span class="text-sm text-white font-bold">{{ $index + 1 }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $stage->selectionStage->name }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $stage->selectionStage->description }}</p>
                                        
                                        <div class="mt-1 flex flex-wrap gap-2">
                                            @if($stage->status == 'pending')
                                                <button type="button" class="text-xs text-blue-700 bg-blue-100 px-2 py-1 rounded-md schedule-btn" data-id="{{ $stage->id }}">
                                                    @if($stage->scheduled_date)
                                                        Reschedule
                                                    @else
                                                        Schedule
                                                    @endif
                                                </button>
                                                
                                                <form action="{{ route('hrd.application-stages.update', $stage) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="passed">
                                                    <button type="submit" class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded-md">Mark Passed</button>
                                                </form>
                                                
                                                <form action="{{ route('hrd.application-stages.update', $stage) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="failed">
                                                    <button type="submit" class="text-xs text-red-700 bg-red-100 px-2 py-1 rounded-md">Mark Failed</button>
                                                </form>
                                            @endif
                                        </div>
                                        
                                        @if($stage->status == 'pending' && $stage->scheduled_date)
                                            <div class="mt-2 bg-blue-50 p-2 rounded-md">
                                                <p class="text-xs text-blue-800">
                                                    <span class="font-semibold">Scheduled: </span>
                                                    {{ $stage->scheduled_date->format('l, F j, Y \a\t g:i A') }}
                                                </p>
                                                @if($stage->notes)
                                                    <p class="text-xs text-blue-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @elseif($stage->status == 'passed')
                                            <div class="mt-2 bg-green-50 p-2 rounded-md">
                                                <p class="text-xs text-green-800">
                                                    <span class="font-semibold">Completed: </span>
                                                    {{ $stage->completed_date ? $stage->completed_date->format('M d, Y') : 'N/A' }}
                                                </p>
                                                @if($stage->score)
                                                    <p class="text-xs text-green-800">
                                                        <span class="font-semibold">Score: </span>
                                                        {{ $stage->score }}/100
                                                    </p>
                                                @endif
                                                @if($stage->notes)
                                                    <p class="text-xs text-green-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @elseif($stage->status == 'failed')
                                            <div class="mt-2 bg-red-50 p-2 rounded-md">
                                                <p class="text-xs text-red-800">
                                                    <span class="font-semibold">Result: </span>
                                                    Not selected to move forward
                                                </p>
                                                @if($stage->score)
                                                    <p class="text-xs text-red-800">
                                                        <span class="font-semibold">Score: </span>
                                                        {{ $stage->score }}/100
                                                    </p>
                                                @endif
                                                @if($stage->notes)
                                                    <p class="text-xs text-red-600 mt-1">{{ $stage->notes }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Documents -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cover Letter -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Cover Letter</h3>
                        <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-800 whitespace-pre-wrap">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                </div>

                <!-- CV and Additional Documents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Application Documents</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            @if ($application->cv_path)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center min-w-0">
                                    {{-- [1] Ikon SVG ditambahkan kembali di sini --}}
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">CV / Resume</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($application->cv_path) }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                        View
                                    </a>
                                </div>
                            </li>
                            @endif
                            
                            @foreach($application->documents as $document)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center min-w-0">
                                    {{-- [2] Ikon SVG juga ditambahkan untuk setiap dokumen tambahan --}}
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ ucfirst($document->document_type) }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($document->file_path) }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 text-sm">
                                        View
                                    </a>
                                </div>
                            </li>
                            @endforeach
                            
                            {{-- Kondisi jika tidak ada dokumen sama sekali --}}
                            @if($application->documents->isEmpty() && !$application->cv_path)
                            <li class="py-3 text-sm text-gray-500 text-center">
                                No documents provided.
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Application Notes</h3>
                    
                    @if($application->notes)
                        <div class="bg-gray-50 p-4 rounded-md mb-4">
                            <div class="text-sm text-gray-800 whitespace-pre-wrap">
                                {{ $application->notes }}
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 mb-4">
                            No notes have been added yet.
                        </div>
                    @endif
                    
                    <form action="{{ route('hrd.applications.notes.add', $application) }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Add Note</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add your notes about this application..."></textarea>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Modal -->
    <div id="schedule-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Schedule Stage
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Please select a date and time for this stage.
                        </p>
                    </div>
                </div>
            </div>
            
            <form id="schedule-form" action="" method="POST" class="mt-6">
                @csrf
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700">Date and Time</label>
                    <input type="datetime-local" name="scheduled_date" id="scheduled_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                    <textarea id="modal-notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Add details about this scheduled stage..."></textarea>
                </div>
                
                <div class="mt-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Schedule
                    </button>
                    <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Schedule modal functionality
            const scheduleButtons = document.querySelectorAll('.schedule-btn');
            const scheduleModal = document.getElementById('schedule-modal');
            const scheduleForm = document.getElementById('schedule-form');
            const closeModalButton = document.getElementById('close-modal');
            
            scheduleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const stageId = this.getAttribute('data-id');
                        let urlTemplate = "{{ route('hrd.application-stages.schedule', ['applicationStage' => 'PLACEHOLDER_ID']) }}";
                        let finalUrl = urlTemplate.replace('PLACEHOLDER_ID', stageId);
                        scheduleForm.action = finalUrl;
                    scheduleModal.classList.remove('hidden');
                });
            });
            
            closeModalButton.addEventListener('click', function() {
                scheduleModal.classList.add('hidden');
            });
            
            // Close modal when clicking outside
            scheduleModal.addEventListener('click', function(e) {
                if (e.target === scheduleModal) {
                    scheduleModal.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>