<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hrdId = auth()->id();

        // Ambil ID lowongan yang dibuat oleh HRD ini saja
        $hrdJobVacancyIds = JobVacancy::where('created_by', $hrdId)->pluck('id');

        // Hitung statistik hanya dari lowongan yang relevan
        $activeVacancies = JobVacancy::whereIn('id', $hrdJobVacancyIds)->where('status', 'active')->count();
        $totalApplications = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)->count();
        $newApplications = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)->where('created_at', '>=', now()->subDays(7))->count();

        // Ambil data untuk jadwal interview mendatang
        $upcomingInterviews = \App\Models\ApplicationStage::with(['application.user', 'application.jobVacancy', 'selectionStage'])
            ->whereHas('application', function ($query) use ($hrdJobVacancyIds) {
                $query->whereIn('job_vacancy_id', $hrdJobVacancyIds);
            })
            ->where('status', 'pending')
            ->whereNotNull('scheduled_date')
            ->where('scheduled_date', '>=', now())
            ->orderBy('scheduled_date')
            ->take(5)
            ->get();
            
        $recentApplications = Application::with(['user', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->latest()
            ->take(5)
            ->get();

        // [KODE BARU] Ambil data untuk chart distribusi status
        $applicationStatuses = Application::whereIn('job_vacancy_id', $hrdJobVacancyIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('hrd.dashboard', compact(
            'activeVacancies',
            'totalApplications',
            'newApplications',
            'upcomingInterviews',
            'recentApplications',
            'applicationStatuses' // <-- Kirim data baru ke view
        ));
    }
}