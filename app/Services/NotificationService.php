<?php

Namespace App\Services;

use App\Models\Appointment;
use App\Traits\EmailNotifications;
use App\Traits\SmsNotifications;

class NotificationService {

    use EmailNotifications, SmsNotifications;

    public function sendNotification($type, Appointment $appointment) {

        switch ($type) {
            case 'Email':
                $this->sendEmailNotification($appointment);
                break;
            case 'Phone':
                $this->sendSmsNotification($appointment);
                break;
            default:
                return session()->flash("error", "Notification not Supported");
        }

}

}
