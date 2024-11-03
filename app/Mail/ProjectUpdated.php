<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $changedData;
    public $project;

    public function __construct($project, $changedData)
    {
        $this->project = $project;
        $this->changedData = $changedData;
    }

    public function build()
    {
        return $this->subject('Projekt módosult')
                    ->view('emails.project-updated')
                    ->with([
                        'project' => $this->project,
                        'changedData' => $this->changedData,
                    ]);
    }
}
