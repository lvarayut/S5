<?php

namespace Enstb\Bundle\VisplatBundle\Graph;

/**
 * Class GraphChart
 * @package Enstb\Bundle\VisplatBundle\Graph
 */
class GraphChart
{
    /**
     * Create a pie chart data
     * @param $data all events from DB
     * @return  JSON data
     */
    public static function createPieChart($data, $days)
    {

// total as 24 hours (in seconds) // has to be changed if change of scale (week, month)

        $total = 24 * 3600 * $days;

        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]['Duration'] = $data[$i]['Time'] / $total;
        }

// time spent we don't know how

        $rest = 0;
        $amount = 0;
        $max = sizeof($data);
        for ($i = 0; $i < $max; $i++) {
            $amount = $amount + $data[$i]['Time'];
        }
        $rest = $total - $amount;


        $data[$max]['Event'] = "unknown";
        $data[$max]['Begin'] = "0000-00-00 00:00:00";
        $data[$max]['End'] = "0000-00-00 00:00:00";
        $data[$max]['Frequency'] = 1;
        $data[$max]['Time'] = $rest;
        $data[$max]['Duration'] = $rest / $total;

        return json_encode($data);
    }


    /**
     * Create a Gantt chart data
     * @param $data all events from DB
     * @return  JSON data
     */
    public static function createGanttChart($data)
    {

        $status = null;

        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]['status'] = $status;
        }

        return json_encode($data);

    }

    /**
     * Create a chord diagram data
     * @param $data all events from DB
     * @return  Two dimensional arrays of Events and Matrix
     */
    public static function createChordDiagram($data, $distinctEvents)
    {
        // Two dimensional arrays counting occurred events
        $occur = array();
        $events = array();
        // Remove outer array
        foreach ($distinctEvents as $eachEvent) {
            $events[] = $eachEvent['taskName'];
        }
        foreach ($data as $datum) {
            $eventsTran[] = $datum['taskName'];
        }
        if (sizeof($data) < 2) {
            $matrix[] = array(1);
            return array('events' => $events, 'matrix' => $matrix);
        } else {
            // Initialize
            for ($i = 0; $i < sizeof($events); $i++) {
                for ($j = 0; $j < sizeof($events); $j++) {
                    $occur[$events[$i]][$events[$j]] = 0;
                }
            }
            // Get each array of events
            for ($i = 1; $i < sizeof($eventsTran); $i++) {
                // The first event and the second event
                $occur[$eventsTran[$i - 1]][$eventsTran[$i]] += 1;
                // Inversely
                $occur[$eventsTran[$i]][$eventsTran[$i - 1]] += 1;
            }
        }
        // Create matrix
        $matrix = array();
        for ($i = 0; $i < sizeof($events); $i++) {
            $row = array();
            for ($j = 0; $j < sizeof($events); $j++) {
                $row[] = $occur[$events[$i]][$events[$j]];

            }

            $matrix[] = $row;
        }
        return array('events' => $events, 'matrix' => $matrix);
    }

}