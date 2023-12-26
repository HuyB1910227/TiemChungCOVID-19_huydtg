<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ConfirmRegistrationVaccination;
use Illuminate\Support\Facades\Mail;


class SendConfirmRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $form;
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            "vaccination_date" =>  $this->form->schedule->vaccination_date,
            "vaccination_date" =>  $this->form->schedule->vaccination_date,
            "vaccination_start" => $this->form->schedule->start_time,
            "vaccination_end" => $this->form->schedule->end_time,
            "immunization_name" =>  $this->form->schedule->immunizationUnit->name,
            "immunization_address" =>  $this->form->schedule->immunizationUnit->address,
            "vaccine_name" =>  $this->form->schedule->vaccine->name,
            "immunization_hotline" =>  $this->form->schedule->immunizationUnit->hotline,

        ];
        Mail::to($this->form->patient->email)->send(new ConfirmRegistrationVaccination($data));
    }
}
