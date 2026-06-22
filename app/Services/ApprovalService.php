<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApprovalService
{
    public function submit(Project $project, User $user): Approval
    {
        return Approval::create([
            'project_id' => $project->id,
            'requested_by' => $user->id,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }

    public function approve(Approval $approval, User $reviewer, ?string $notes = null): Approval
    {
        $approval->update([
            'status' => 'approved',
            'reviewed_by' => $reviewer->id,
            'notes' => $notes,
            'reviewed_at' => now(),
        ]);

        $approval->project->update(['status' => 'approved']);

        return $approval->fresh();
    }

    public function reject(Approval $approval, User $reviewer, string $notes): Approval
    {
        $approval->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewer->id,
            'notes' => $notes,
            'reviewed_at' => now(),
        ]);

        $approval->project->update(['status' => 'rejected']);

        return $approval->fresh();
    }
}
