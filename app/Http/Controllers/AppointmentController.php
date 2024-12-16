<?php

namespace App\Http\Controllers;

use App\Models\{Appointment, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentDateTime = Carbon::now($user->preferred_timezone);

        $appointments = Appointment::select('appointments.*')
            ->join('user_appointment', 'user_appointment.appointment_id', '=', 'appointments.id')
            ->where('user_appointment.user_id', $user->id)
            ->whereRaw("CONVERT_TZ(appointments.start, '+00:00', ?) > ?", [$user->preferred_timezone, $currentDateTime])
            ->orderBy('appointments.start', 'asc')
            ->paginate(5);


        $appointmentss = [];
        foreach ($appointments as $appointment) {
            $startLocal = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->start, 'UTC')
                ->setTimezone($user->preferred_timezone);

            $endLocal = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->end, 'UTC')
                ->setTimezone($user->preferred_timezone);

            $appointmentss[] = [
                'id' => $appointment->id,
                'title' => $appointment->title,
                'start' => $startLocal,
                'end' => $endLocal,
                'creator' => $appointment->creator->name,
                'participants' => $appointment->users->pluck('name')->toArray(),
            ];
        }

        return view('appointments.index', compact('appointmentss', 'appointments'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $user = Auth::user();
        $now = Carbon::now($user->preferred_timezone);
        $minDate = $now->toDateString();

        return view('appointments.create', [
            'users' => $users,
            'minDate' => $minDate,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i', 'after:start'],
            'participants' => ['required', 'array', 'min:1'],
        ]);

        $startDateTime = $request['date'] . ' ' . $request['start'];
        $endDateTime = $request['date'] . ' ' . $request['end'];

        $startUTC = Carbon::createFromFormat('Y-m-d H:i', $startDateTime, $user->preferred_timezone)->setTimezone('UTC');
        $endUTC = Carbon::createFromFormat('Y-m-d H:i', $endDateTime, $user->preferred_timezone)->setTimezone('UTC');

        if (Carbon::now($user->preferred_timezone)->gt($startUTC)) {
            return back()->with("error", 'The start time cannot be in the past.');
        }

        foreach (User::whereIn('id', $request['participants'])->get()->push($user) as $participant) {
            $startLocal = $startUTC->copy()->setTimezone($participant->preferred_timezone);
            $endLocal = $endUTC->copy()->setTimezone($participant->preferred_timezone);

            $workStart = Carbon::createFromFormat(
                'Y-m-d H:i',
                $startLocal->format('Y-m-d') . ' 08:00',
                $participant->preferred_timezone
            );

            $workEnd = Carbon::createFromFormat(
                'Y-m-d H:i',
                $startLocal->format('Y-m-d') . ' 17:00',
                $participant->preferred_timezone
            );

            if ($startLocal->lt($workStart) || $startLocal->gt($workEnd) || $endLocal->lt($workStart) || $endLocal->gt($workEnd)) {
                return back()->with("error", "The appointment is invalid for {$participant->name} because it is outside their working hours (08:00-17:00).");
            }
        }

        $participantIds = array_merge($request['participants'], [$user->id]);
        foreach ($participantIds as $participantId) {
            $query = "
                SELECT 1 
                FROM appointments a
                JOIN user_appointment ua ON a.id = ua.appointment_id
                WHERE ua.user_id = ? 
                AND (
                    (a.start BETWEEN ? AND ?) 
                    OR (a.end BETWEEN ? AND ?)
                    OR (a.start < ? AND a.end > ?)
                ) 
                LIMIT 1;
            ";

            $overlap = DB::select($query, [
                $participantId,
                $startUTC,
                $endUTC,
                $startUTC,
                $endUTC,
                $startUTC,
                $endUTC
            ]);

            if (!empty($overlap)) {
                return back()->with("error", "One or more participants already have an appointment at the selected time.");
            }
        }

        $attributes = $request->only(['title', 'date', 'start', 'end']);
        $attributes['start'] = $startUTC;
        $attributes['end'] = $endUTC;
        $attributes['creator_id'] = $user->id;

        $appointment = Appointment::create($attributes);

        $participants = User::whereIn('id', $request['participants'])->get();
        $participants->push($user);

        foreach ($participants as $participant) {
            $appointment->users()->attach($participant->id);
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }
}
