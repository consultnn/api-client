<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 05.10.14
 * Time: 17:29
 */

namespace consultnn\api\mappers;


class Schedule extends AbstractMapper
{
    public $schedule = [];

    private $_lazyDays = [];

    public function setBusyHours($value) {
        $schedule = mb_strtolower($value);
        try {

            if (mb_strpos($schedule, '(')) {
                $schedule = trim(mb_ereg_replace('\(.*\)', '', $schedule));
            }

            mb_ereg_search_init($schedule);
            if (mb_ereg_search('[а-я]\:')) {
                $schedule = mb_ereg_replace('^[\w-]+\:', '', $schedule);
                $schedule = mb_ereg_replace(', [\w-]+\:', ',', $schedule);
            }
            $schedule = trim($schedule);
            $dayIntervals = explode(',', $schedule);

            foreach ($dayIntervals as $dayInterval) {
                $dayInterval = trim($dayInterval);
                if (mb_strpos($dayInterval, 'обед') === false) {
                    $this->parseDayInterval($dayInterval);
                } else {
                    list($trash, $time) = explode(' ', $dayInterval);
                    $this->parseLunch($time);
                }
            }
        } catch (\Exception $e) {
            $this->schedule = 'error parsing';
        }
    }

    private function parseLunch($time)
    {
        $lunchTime = $this->parseTime($time);
        foreach ($this->schedule as $day => &$workingTime) {
            if ($this->greaterTime($lunchTime['from'], $workingTime['from']) && $this->greaterTime($workingTime['to'], $lunchTime['to'])) {
                $workingTime = [
                    [
                        'from' => $workingTime['from'],
                        'to' => $lunchTime['from']
                    ],
                    [
                        'from' => $lunchTime['to'],
                        'to' => $workingTime['to']
                    ]
                ];
            }
        }
    }

    private function greaterTime($time1, $time2)
    {
        if ($time1['hours'] > $time2['hours']) {
            return true;
        } elseif ($time1['hours'] == $time2['hours'] && $time1['minutes'] > $time2['minutes']) {
            return true;
        } else {
            return false;
        }
    }

    private function parseDayInterval($dayInterval)
    {
        static $daysTransform = [
            'пн' => 'Mon',
            'вт' => 'Tue',
            'ср' => 'Wed',
            'чт' => 'Thu',
            'пт' => 'Fri',
            'сб' => 'Sat',
            'вс' => 'Sun',
        ];

        $dayParts = explode(' ', $dayInterval);

        if (count($dayParts) > 2) {
            $dayParts = array_slice($dayParts, count($dayParts) -1, 2);
        }

        if (count($dayParts) == 2) {
            list($days, $hours) = $dayParts;
        } else {
            $days = $dayInterval;
        }


        if (mb_strpos($days, '-') != false) {
            list($dayFrom, $dayTo) = explode('-',$days);
        } else {
            $dayFrom = $dayTo = $days;
        }

        $scheduleDay = null;
        if (!empty($hours)) {
            $scheduleDay = $this->parseTime($hours);
        }

        $start = false;

        foreach ($daysTransform as $dayName => $dayValue) {
            if ($dayFrom == $dayName || $start) {
                if ($scheduleDay !== null) {
                    $this->schedule[$dayValue] = $scheduleDay;
                } else {
                    $this->_lazyDays[$dayName] = $scheduleDay;
                }
                $start = true;
            }

            if ($dayTo == $dayName) {
                break;
            }
        }

        if (!empty($scheduleDay)) {
            foreach ($this->_lazyDays as $dayName => $dayValue) {
                $this->schedule[$dayName] = $scheduleDay;
                unset($this->_lazyDays[$dayName]);
            }
        }
    }

    private function parseTime($hours)
    {
        if ($hours == 'круглосуточно') {
            return [
                'from' => [
                    'hours' => 0,
                    'minutes' => 0
                ],
                'to' => [
                    'hours' => 24,
                    'minutes' => 0
                ],
            ];
        }


        list($timeFrom, $timeTo) = explode('-',$hours);
        list($hoursFrom, $minutesFrom) = explode(':', $timeFrom);
        list($hoursTo, $minutesTo) = explode(':', $timeTo);
        return [
            'from' => [
                'hours' => (int)$hoursFrom,
                'minutes' => (int)$minutesFrom
            ],
            'to' => [
                'hours' => (int)$hoursTo,
                'minutes' => (int)$minutesTo
            ]
        ];
    }
} 