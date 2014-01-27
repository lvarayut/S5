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
    public static function createPieChart($data)
    {

// total as 24 hours (in seconds)

        $total = 24 * 3600;

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
}