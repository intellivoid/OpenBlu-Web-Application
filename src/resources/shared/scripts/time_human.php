<?PHP

    /**
     * @param $time
     * @param $time_text
     * @return mixed
     */
    function build_time_elapsed_string($time, $time_text)
    {
        $Text = TEXT_UPDATED_TIME_FORMAT;
        $Text = str_ireplace('%time', $time, $Text);
        $Text = str_ireplace('%text', $time_text, $Text);
        return $Text;
    }

    /**
     * @param $ptime
     * @return mixed
    */
    function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return build_time_elapsed_string(0, TEXT_UPDATED_TIME_PLURAL_SECOND);
        }

        $a = array( 365 * 24 * 60 * 60  =>  TEXT_UPDATED_TIME_YEAR,
            30 * 24 * 60 * 60  =>  TEXT_UPDATED_TIME_MONTH,
            24 * 60 * 60  =>  TEXT_UPDATED_TIME_DAY,
            60 * 60  =>  TEXT_UPDATED_TIME_HOUR,
            60  =>  TEXT_UPDATED_TIME_MINUTE,
            1  =>  TEXT_UPDATED_TIME_SECOND
        );
        $a_plural = array(
            TEXT_UPDATED_TIME_YEAR   => TEXT_UPDATED_TIME_PLURAL_YEAR,
            TEXT_UPDATED_TIME_MONTH  => TEXT_UPDATED_TIME_PLURAL_MONTH,
            TEXT_UPDATED_TIME_DAY    => TEXT_UPDATED_TIME_PLURAL_DAY,
            TEXT_UPDATED_TIME_HOUR   => TEXT_UPDATED_TIME_PLURAL_HOUR,
            TEXT_UPDATED_TIME_MINUTE => TEXT_UPDATED_TIME_PLURAL_MINUTE,
            TEXT_UPDATED_TIME_SECOND => TEXT_UPDATED_TIME_PLURAL_SECOND
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return build_time_elapsed_string($r, ($r > 1 ? $a_plural[$str] : $str));
            }
        }

        return build_time_elapsed_string(0, TEXT_UPDATED_TIME_PLURAL_SECOND);
    }