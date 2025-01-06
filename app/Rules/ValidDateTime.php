<?php

namespace App\Rules;

use App\Models\Appointment;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDateTime implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected string $open_hour = "09:00";
    protected string $close_hour = "18:30";

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dateField = "date";
        $date = request($dateField);
        $time = $value;

        //Check if the time format is correct H:i
        try {
            Carbon::createFromFormat('H:i', $time);
        }
        catch (\Exception $e) {
            $fail("Please enter a valid time - HH:MM (e.g - 09:50)");
            return;
        }

        //Check if date format is correct d-m-Y
        try {
            Carbon::createFromFormat('d-m-Y', $date);
        }
        catch (\Exception $e) {
            $fail("Please enter a valid date - dd-mm-YYYY (e.g - 20-05-2027)");
            return;
        }

        //Check if the appointment time is during working hours
        $open = Carbon::createFromTimeString($this->open_hour);
        $close = Carbon::createFromTimeString($this->close_hour);

        $appointmentTime = Carbon::createFromTimeString($time);


        if(!$appointmentTime->between($open, $close) ) {
            $fail("Outside working hours. The appointment time must be between $this->open_hour and $this->close_hour.");
        }

        //Check if the appointment is set for future period
        $date_time = Carbon::createFromFormat("d-m-Y H:i", $date . " " . $time, timezone_open("Europe/Sofia"));

        if($date_time < Carbon::now("Europe/Sofia")) {
            $fail("Please enter a future appointment date and time.");
        }

        //Check if appointment hour is taken

        $isAppointmentTaken = Appointment::where("date", $date)->where("time", $time)->first();
        if($isAppointmentTaken) {
            $fail("This hour is already taken. Please choose another hour.");
        }

    }
}
