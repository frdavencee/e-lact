<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApproved extends Notification
{
    use Queueable;

    public function __construct(public $project) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => "Project {$this->project->nama_proyek} telah disetujui.",
            'url' => route('projects.show', $this->project),
        ];
    }
}
