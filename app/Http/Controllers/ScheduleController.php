<?php

namespace App\Http\Controllers;

use App\Enums\ModuleName;
use App\Models\Preference;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Shift_In_Schedule;
use App\Models\User;
use App\Models\User_In_Schedule;
use App\Notifications\DbNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class ScheduleController extends Controller
{
    public function current()
    {
        $currentDate = Carbon::today()->startOfMonth();
        $currentDate->format('Y-m-d');
        $schedule = Schedule::where([
            ['date', '=', $currentDate],
            ['is_public', '=', 1],
        ])->first();
        if ($schedule === null) {
            return redirect()->route('userSchedule')->with('error', 'Brak grafiku do wyświetlenia!');
        } else {
            $userInSchedules = User_In_Schedule::where('schedule_id', '=', $schedule->id)->get();
            $shifts = Shift_In_Schedule::where('schedule_id', '=', $schedule->id)->get();
            $month = $currentDate->month;
            $year = $currentDate->year;
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            return view('schedule.current',[
                'scheduleName' => $schedule->name,
                'userInSchedule' => $userInSchedules,
                'shifts' => $shifts,
                'month' => $month,
                'year' => $year,
                'daysInMonth' =>$daysInMonth
            ]);
        }
    }

    public function individual()
    {
        $userId = Auth::id();
        $currentDate = Carbon::today()->startOfMonth();
        $currentDate->format('Y-m-d');
        $schedule = Schedule::where([
            ['date', '=', $currentDate],
            ['is_public', '=', 1],
        ])->first();
        if ($schedule === null) {
            return redirect()->route('userSchedule')->with('error', 'Brak grafiku do wyświetlenia!');
        } else {
            $userInSchedules = User_In_Schedule::where([
                ['schedule_id', '=', $schedule->id],
                ['user_id', '=',  $userId],
                ])->get();
            $shifts = Shift_In_Schedule::where('schedule_id', '=', $schedule->id)->get();
            $month = $currentDate->month;
            $year = $currentDate->year;
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            return view('schedule.individual',[
                'scheduleName' => $schedule->name,
                'userInSchedule' => $userInSchedules,
                'shifts' => $shifts,
                'month' => $month,
                'year' => $year,
                'daysInMonth' =>$daysInMonth
            ]);
        }
    }

    public function index()
    {
        $schedules = Schedule::where('is_public', '=', 1)->orderBy('created_at', 'desc')->get();
        return view('schedule.archives', ['schedules' => $schedules]);
    }

    public function indexAdmin()
    {
        $schedules = Schedule::orderBy('created_at', 'desc')->get();
        return view('schedule.manage', ['schedules' => $schedules]);
    }

    public function create()
    {
        $shift = Shift::all();
        return view('schedule.create', [
            'shifts' => $shift
        ]);
    }

    public function save(Request $request)
    {
        if($request->has('shift')) {
            $date = $request->year."-".$request->month;
            $schedule = new Schedule();
            $schedule->name = $request->name;
            $schedule->date = $date;
            $schedule->is_public = false;
            $schedule->save();
            foreach($request->shift as $shift) {
                $shiftInSchedule = new Shift_In_Schedule();
                $shiftInSchedule->schedule_id = $schedule->id;
                $shiftInSchedule->shift_id = $shift;
                $shiftInSchedule->save();
            }
            return redirect()->route('scheduleEdit', $schedule->id);
        } else {
            return redirect()->route('scheduleCreate')->with('error', 'Musisz wybrać conajmniej jedną zmianę!');
        }
    }

    public function store(Request $request)
    {
        $scheduleId = $request->schedule;
        $daysInMonth = $request->daysInMonth;
        $month = $request->month;
        $year = $request->year;

        $shifts = Shift_In_Schedule::where('schedule_id', '=', $scheduleId)->get();

        $schedule = Schedule::find($scheduleId);
        $schedule->name = $request->name;
        $schedule->save();

        $rowAdded = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
            foreach ($shifts as $shift) {
                for ($positionInShift = 1; $positionInShift <= $shift->shift->number_of_employees; $positionInShift++) {
                    $userInSchedules = $request->input('user_'.$positionInShift.'_shift_'.$shift->shift_id.'_date_'.$day);
                    if ($userInSchedules == -1 || $userInSchedules == "-1" || $userInSchedules == NULL || $userInSchedules == "null") {
                        // Brak akcji...
                    } else {
                        $notify = $this->processUserInSchedules($userInSchedules, $date, $shift->shift_id, $positionInShift, $scheduleId);
                        $rowAdded++;
                        if ($schedule->is_public == true && $notify == true) {
                            $message = 'Została przypisana do Ciebie zmiana w grafiku '.$schedule->name.' dotyczy zmiany '.$shift->shift->name.' dnia '.$date;
                            Notification::send(User::find($userInSchedules), new DbNotification($message, ModuleName::SCHEDULE));
                        }
                    }
                }
            }
        }
        if ($rowAdded == 0) {
            $request->session()->put('error', 'Brak zmian do zapisania!');
            $request->session()->save();
            return redirect()->route('scheduleEdit', $scheduleId);
        } else {
            $request->session()->put('success', 'Grafik został poprawnie zapisany!');
            $request->session()->save();

            return redirect()->route('scheduleEdit', $scheduleId);
        }
    }


    private function processUserInSchedules($userId, $date, $shiftId, $positionInShift, $scheduleId)
    {
        $check = User_In_Schedule::where([
            ['date', '=', $date],
            ['shift_id', '=', $shiftId],
            ['schedule_id', '=', $scheduleId],
            ['position_in_shift', '=', $positionInShift],
        ])->first();
        if ($check === null) {
            return $this->saveUserInSchedules($userId, $date, $shiftId, $positionInShift, $scheduleId);
        } else {
            return $this->updateUserInSchedules($check, $userId);
        }
    }

    private function saveUserInSchedules($userId, $date, $shiftId, $positionInShift, $scheduleId)
    {
        $userInSchedules = new User_In_Schedule();
        $userInSchedules->user_id = $userId;
        $userInSchedules->schedule_id = $scheduleId;
        $userInSchedules->shift_id = $shiftId;
        $userInSchedules->date = $date;
        $userInSchedules->position_in_shift = $positionInShift;
        $userInSchedules->save();
        return true;
    }

    private function updateUserInSchedules($userInSchedules, $userId)
    {
        if ($userInSchedules->user_id == $userId) {
            return false;
        } else {
            $userInSchedules->user_id = $userId;
            $userInSchedules->save();
            return true;
        }


    }

    public function show($id)
    {
        $schedule = Schedule::find($id);
        $currentDate = Carbon::parse($schedule->date);
        if ($schedule === null) {
            return redirect()->route('userSchedule')->with('error', 'Brak grafiku do wyświetlenia!');
        } else {
            $userInSchedules = User_In_Schedule::where('schedule_id', '=', $schedule->id)->get();
            $shifts = Shift_In_Schedule::where('schedule_id', '=', $schedule->id)->get();
            $month = $currentDate->month;
            $year = $currentDate->year;
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            return view('schedule.current',[
                'scheduleName' => $schedule->name,
                'userInSchedule' => $userInSchedules,
                'shifts' => $shifts,
                'month' => $month,
                'year' => $year,
                'daysInMonth' =>$daysInMonth
            ]);
        }
    }

    public function edit($id)
    {
        $users = User::all();
        $schedule = Schedule::find($id);
        $startDate = Carbon::parse($schedule->date);
        $month = $startDate->month;
        $year = $startDate->year;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $shifts = Shift_In_Schedule::where('schedule_id', '=', $id)->get();
        $preferences = Preference::whereBetween('date' , [$startDate->toDateString(), $startDate->endOfMonth()->toDateString()])->get();
        $userInSchedules = User_In_Schedule::where('schedule_id', '=', $id)->get();
        return view('schedule.edit', [
            'schedule' => $schedule,
            'shifts' => $shifts,
            'month' => $month,
            'year' => $year,
            'daysInMonth' => $daysInMonth,
            'users' => $users,
            'preferences' => $preferences,
            'userInSchedule' => $userInSchedules
        ]);
    }

    private function isPublic($id, $isPublic) {
        $schedule = Schedule::find($id);
        $schedule->is_public = $isPublic;
        $schedule->save();
        return $schedule;
    }

    public function public($id)
    {
        $schedule = $this->isPublic($id, true);
        $message = 'Nowy grafik o nazwie: "'.$schedule->name.'" został opublikowany!';
        Notification::send(User::all(), new DbNotification($message, ModuleName::SCHEDULE));
        return redirect()->route('scheduleManage')->with('status', 'Grafik został opublikowany i powiadomienie do pracowników zostało wysłane!');
    }

    public function unPublic($id)
    {
        $schedule = $this->isPublic($id, false);
        return redirect()->route('scheduleManage')->with('warning', 'Grafik nie jest już publiczny!');
    }
}
