@php
    function polishDay($day, $month, $year) {
        $dayOfWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
        switch($dayOfWeek){
            case 1:
                return 'Pon';
                break;
            case 2:
                return 'Wt';
                break;
            case 3:
                return 'Śr';
                break;
            case 4:
                return 'Czw';
                break;
            case 5:
                return 'Pt';
                break;
            case 6:
                return 'Sob';
                break;
            case 0:
                return 'Nd';
                break;
        }
    }
    function displayEmployees($numberOfEmployees, $users, $shift, $day, $month, $year, $preferences) {
        $checkDay = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        for ($i=1; $i <= $numberOfEmployees; $i++) {
            echo '<select class="form-select form-select-sm rounded-pill mb-1"
                name="user_'.$i.'_shift_'.$shift.'_date_'.$day.'">';
            echo '<option value="-1"></option>';
            foreach ($users as $user) {
                $loadedPreferencesUser = 0;
                foreach ($preferences as $preference) {
                    if ($preference->date == $checkDay &&
                        $preference->shift_id == $shift &&
                        $preference->user_id == $user->id) {
                            $loadedPreferencesUser = $preference->user_id;
                            if ($preference->available) {
                                echo '<option class="text-success" value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
                            } elseif ($preference->available == 0) {
                                echo '<option class="text-danger" value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
                            }
                    }
                }
                if ($user->id == $loadedPreferencesUser) {
                    continue;
                }
                echo '<option value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
            }
            echo '</select>';
        }
    }
    function loadEmployees($userInSchedule, $numberOfEmployees, $users, $shift, $day, $month, $year, $preferences) {
        $checkDay = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        for ($i=1; $i <= $numberOfEmployees; $i++) {
            echo '<select class="form-select form-select-sm rounded-pill mb-1"
                name="user_'.$i.'_shift_'.$shift.'_date_'.$day.'">';
                echo '<option value="-1"></option>';
            $loadedEmployee = 0;
            foreach ($userInSchedule as $user) {
                if ($user->shift_id == $shift &&
                    $user->date == $checkDay &&
                    $user->position_in_shift == $i) {
                        $loadedEmployee = $user->user_id;
                        echo '<option value="'.$user->user->id.'" selected>'.$user->user->first_name.' '.$user->user->last_name.'</option>';
                        break;
                    }
            }
            foreach ($users as $user) {
                if ($user->id == $loadedEmployee) {
                    continue;
                }
                $loadedPreferencesUser = 0;
                foreach ($preferences as $preference) {
                    if ($preference->date == $checkDay &&
                        $preference->shift_id == $shift &&
                        $preference->user_id == $user->id) {
                            $loadedPreferencesUser = $preference->user_id;
                            if ($preference->available) {
                                echo '<option class="text-success" value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
                            } elseif ($preference->available == 0) {
                                echo '<option class="text-danger" value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
                            }
                    }
                }
                if ($user->id == $loadedPreferencesUser) {
                    continue;
                }
                echo '<option value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
            }
            echo '</select>';
        }
    }
    function currentSchedule2($userInSchedule, $numberOfEmployees, $shift, $day, $month, $year) {
        $checkDay = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        for ($i=1; $i <= $numberOfEmployees; $i++) {
            echo '<select class="form-select form-select-sm rounded-pill mb-1" disabled>';
                echo '<option value="-1"></option>';
            $loadedEmployee = 0;
            foreach ($userInSchedule as $user) {
                if ($user->shift_id == $shift &&
                    $user->date == $checkDay &&
                    $user->position_in_shift == $i) {
                        $loadedEmployee = $user->user_id;
                        echo '<option value="'.$user->user->id.'" selected>'.$user->user->first_name.' '.$user->user->last_name.'</option>';
                        break;
                    }
            }
            echo '</select>';
        }
    }
    function currentSchedule($userInSchedule, $numberOfEmployees, $shift, $day, $month, $year) {
        $checkDay = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        for ($i=1; $i <= $numberOfEmployees; $i++) {
            echo '<div>';
            $loadedEmployee = 0;
            foreach ($userInSchedule as $user) {
                if ($user->shift_id == $shift &&
                    $user->date == $checkDay &&
                    $user->position_in_shift == $i) {
                        $loadedEmployee = $user->user_id;
                        echo '<div>'.$user->user->first_name.' '.$user->user->last_name.'</div>';
                        break;
                    }
            }
            echo '</div>';
        }
    }
    function checkDayOff($month, $i, $year) {
        $easter = easter_date($year, CAL_EASTER_ALWAYS_GREGORIAN);
        $easter = strtotime("+1 day", $easter);
        $easterMonday = strtotime("+1 day", $easter);
        $bozeCialo = strtotime("+60 days", easter_date($year));
        if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "01-01") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "01-06") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), date("m-d", $easter)) == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), date("m-d", $easterMonday)) == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "05-01") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "05-03") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), date("m-d", $bozeCialo)) == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "08-15") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "11-01") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "11-11") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "12-25") == 0 ||
            strcmp(date("m-d", mktime(0, 0, 0, $month, $i, $year)), "12-26") == 0){
                return true;
        } else {
            return false;
        }
    }

    function checkSaturday($month, $day, $year) {
        if(date("w", mktime(0, 0, 0, $month, $day, $year)) == 6) {
            return true;
        } else {
            return false;
        }
    }
    function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
@endphp
