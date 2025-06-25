@extends('layouts.admin')

@section('header')
    {{ __('Admin Dashboard') }}
@endsection

@section('content')
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center mt-4">
                @if(isset($userGrowth) && $userGrowth > 0)
                <span class="flex items-center text-sm text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    {{ $userGrowth }}%
                </span>
                @elseif(isset($userGrowth) && $userGrowth < 0)
                <span class="flex items-center text-sm text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                    {{ abs($userGrowth) }}%
                </span>
                @else
                <span class="flex items-center text-sm text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    5%
                </span>
                @endif
                <span class="text-xs text-gray-500 ml-2">vs last month</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Vacancies</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalVacancies }}</p>
                </div>
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center mt-4">
                <span class="flex items-center text-sm text-gray-600">
                    <span class="font-medium">{{ $activeVacancies }}</span>
                    <span class="ml-1">active</span>
                </span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Applications</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalApplications }}</p>
                </div>
                <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center mt-4">
                <span class="flex items-center text-sm text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    {{ $applicationsLast7Days }} 
                </span>
                <span class="text-xs text-gray-500 ml-2">last 7 days</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Vacancies</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $activeVacancies }}</p>
                </div>
                <div class="p-3 rounded-lg bg-green-50 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center mt-4">
                <span class="flex items-center text-sm text-gray-600">
                    <span class="font-medium">{{ $totalVacancies - $activeVacancies }}</span>
                    <span class="ml-1">closed</span>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- User Roles Chart -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">User Distribution</h3>
                <div class="relative h-64"> <!-- Atur tinggi DI SINI -->
                    <canvas id="user-roles-chart" class="w-full"></canvas>
                </div>
            </div>
        </div>


        <!-- Application Status Chart -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Application Status</h3>
                <div class="relative h-64">
                    <canvas id="application-status-chart" class="w-full"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Applications -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Applications</h3>
                    <a href="{{ route('admin.applications.index') }}" class="text-blue-600 text-sm font-medium hover:text-blue-800">
                        View all
                    </a>
                </div>
                
                @if(count($recentApplications) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b">
                                <th class="pb-3 font-medium">Applicant</th>
                                <th class="pb-3 font-medium">Position</th>
                                <th class="pb-3 font-medium">Status</th>
                                <th class="pb-3 font-medium">Date</th>
                                <th class="pb-3 font-medium"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $application)
                                <tr class="border-b last:border-0 text-sm">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                                {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-medium text-gray-800">{{ $application->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $application->jobVacancy->title }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium 
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
                                    <td class="py-3 pr-4 text-gray-600">{{ $application->created_at->format('M d, Y') }}</td>
                                    <td class="py-3 text-right">
                                        <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        No applications have been submitted yet.
                    </p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Upcoming Interviews -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Upcoming Interviews</h3>
                </div>
                
                @if(isset($upcomingInterviews) && count($upcomingInterviews) > 0)
                <div class="space-y-5">
                    @foreach($upcomingInterviews as $interview)
                    <div class="flex items-center p-4 border rounded-lg hover:bg-gray-50">
                        <div class="flex-shrink-0 h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $interview->application->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $interview->application->jobVacancy->title }} ({{ $interview->selectionStage->name }})</p>
                        </div>
                        <div class="ml-2 text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $interview->scheduled_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $interview->scheduled_date->format('H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming interviews</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        No interviews are scheduled at the moment.
                    </p>
                </div>
                @endif
            </div>
        </div>
        
       <!-- Monthly Applications Chart -->
        <div class="bg-white rounded-xl shadow-sm col-span-1 lg:col-span-2">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Applications</h3>
                <div class="relative h-64">
                    <canvas id="monthly-applications-chart" class="w-full"></canvas>
                </div>
            </div>
        </div>

    
    <!-- Quick Actions -->
    <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-xl">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-6 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-colors duration-150">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-indigo-800">Add User</span>
                </a>
                
                <a href="{{ route('admin.job-vacancies.index') }}" class="flex flex-col items-center p-6 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-150">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-blue-800">Manage Jobs</span>
                </a>
                
                <a href="{{ route('admin.applications.index') }}" class="flex flex-col items-center p-6 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors duration-150">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-purple-800">Review Applications</span>
                </a>
                
                <a href="{{ route('admin.reports.applications') }}" class="flex flex-col items-center p-6 bg-green-50 rounded-xl hover:bg-green-100 transition-colors duration-150">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-800">View Reports</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const colors = {
            roles: {
                'Admin': 'rgba(79, 70, 229, 0.7)',
                'Hrd': 'rgba(59, 130, 246, 0.7)',
                'Applicant': 'rgba(139, 92, 246, 0.7)',
                'default': 'rgba(107, 114, 128, 0.7)'
            },
            statuses: {
                'Applied': 'rgba(107, 114, 128, 0.7)',
                'Screening': 'rgba(59, 130, 246, 0.7)',
                'Interview': 'rgba(139, 92, 246, 0.7)',
                'Test': 'rgba(245, 158, 11, 0.7)',
                'Hired': 'rgba(16, 185, 129, 0.7)',
                'Rejected': 'rgba(239, 68, 68, 0.7)',
                'default': 'rgba(107, 114, 128, 0.7)'
            }
        };

        function renderDoughnutChart(ctx, labels, data, colorMap) {
            const bgColors = labels.map(label => colorMap[label] || colorMap.default);
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: bgColors,
                        borderWidth: 1,
                        borderColor: '#f1f5f9'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        }

        const userRolesData = @json($userRoles ?? []);
        const roleChartEl = document.getElementById('user-roles-chart');
        if (roleChartEl && userRolesData.length > 0) {
            const roles = userRolesData.map(item => ucfirst(item.role));
            const counts = userRolesData.map(item => item.count);
            renderDoughnutChart(roleChartEl, roles, counts, colors.roles);
        }

        const statusData = @json($applicationStatuses ?? []);
        const statusChartEl = document.getElementById('application-status-chart');
        if (statusChartEl && statusData.length > 0) {
            const statuses = statusData.map(item => ucfirst(item.status));
            const counts = statusData.map(item => item.count);
            renderDoughnutChart(statusChartEl, statuses, counts, colors.statuses);
        }

        const monthlyData = @json($monthlyApplications ?? []);
        const monthlyChartEl = document.getElementById('monthly-applications-chart');
        if (monthlyChartEl && monthlyData.length > 0) {
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const labels = monthlyData.map(item => monthNames[item.month - 1] + ' ' + item.year);
            const data = monthlyData.map(item => item.count);
            new Chart(monthlyChartEl, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Applications',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endpush