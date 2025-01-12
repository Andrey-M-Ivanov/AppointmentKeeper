<?php

namespace App\Traits;

use App\Models\Appointment;

trait EmailNotifications {
    public function sendEmailNotification(Appointment $appointment )
    {
        session()->flash("success", "Changes applied successfully. ". $appointment->client->name . " will be informed by email ");
    }
}
