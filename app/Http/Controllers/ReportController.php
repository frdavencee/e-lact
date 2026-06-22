<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query()->with(['project', 'user']);

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($relation) use ($search) {
                        $relation->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $reports = $query->latest()->paginate(15);

        return view('reports.index', compact('reports', 'request'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();

        return view('reports.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'report_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'pd_staff' => 'nullable|string|max:255',
            'findings' => 'nullable|string|max:2000',
            'recommendations' => 'nullable|string|max:2000',
            'action_plan' => 'nullable|string|max:2000',
        ]);

        $validated['user_id'] = auth()->id();

        if (empty($validated['type'])) {
            $validated['type'] = 'lapangan';
        }

        Report::create($validated);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil disimpan.');
    }

    public function show(Report $report)
    {
        $report->load(['project', 'user']);

        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $report->load(['project', 'user']);
        $projects = Project::orderBy('name')->get();

        return view('reports.edit', compact('report', 'projects'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'report_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'pd_staff' => 'nullable|string|max:255',
            'findings' => 'nullable|string|max:2000',
            'recommendations' => 'nullable|string|max:2000',
            'action_plan' => 'nullable|string|max:2000',
        ]);

        $report->update($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
