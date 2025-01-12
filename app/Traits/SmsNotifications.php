<?php

namespace App\Traits;

use App\Models\Appointment;

Trait SmsNotifications {
    public function sendSmsNotification(Appointment $appointment) {

        return session()->flash("success", "Changes applied successfully. ". $appointment->client->name . " will be informed by SMS ");
    }
}
