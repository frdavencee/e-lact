<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ApprovalService;

class ApprovalController extends Controller
{
    protected ApprovalService $service;

    public function __construct(ApprovalService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $query = Approval::with(['project', 'requester', 'reviewer']);

        if (Auth::user()->hasRole('staff')) {
            $query->where('requested_by', Auth::id());
        } elseif (Auth::user()->hasRole('waspang')) {
            $query->where('status', 'submitted');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $approvals = $query->latest()->paginate(10);

        return view('approvals.index', compact('approvals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $project = Project::findOrFail($validated['project_id']);

        if ($project->status !== 'draft') {
            return back()->with('error', 'Project ini sudah pernah disubmit.');
        }

        $this->service->submit($project, Auth::user());
        $project->update(['status' => 'submitted']);

        // Kirim notifikasi ke semua waspang
        \App\Models\User::role('waspang')->get()->each(function ($waspang) use ($project) {
            $waspang->notify(new \App\Notifications\ProjectSubmitted($project));
        });

        return redirect()->route('approvals.index')->with('success', 'Project berhasil disubmit untuk approval.');
    }

    public function show(Approval $approval)
    {
        $approval->load([
            'project.boqItems',
            'project.evidenceImages',
            'project.opmRecords',
            'project.otdrFiles',
            'project.location.commissioningTest',
            'project.location.markingKabel',
            'project.location.fotoLampiran',
            'requester',
            'reviewer'
        ]);

        return view('approvals.show', compact('approval'));
    }

    public function approve(Request $request, Approval $approval)
    {
        if (!Auth::user()->hasRole('waspang')) {
            abort(403);
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $this->service->approve($approval, Auth::user(), $validated['notes']);

        // Notifikasi ke requester
        $approval->requester->notify(new \App\Notifications\ProjectApproved($approval->project));

        return redirect()->route('approvals.index')->with('success', 'Project berhasil disetujui.');
    }

    public function reject(Request $request, Approval $approval)
    {
        if (!Auth::user()->hasRole('waspang')) {
            abort(403);
        }

        $validated = $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $this->service->reject($approval, Auth::user(), $validated['notes']);

        // Notifikasi ke requester
        $approval->requester->notify(new \App\Notifications\ProjectRejected($approval->project, $validated['notes']));

        return redirect()->route('approvals.index')->with('success', 'Project ditolak. Catatan revisi telah dikirim.');
    }
}
