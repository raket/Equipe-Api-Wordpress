<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gustavarrhenius
 * Date: 2013-04-04
 * Time: 16:21
 * To change this template use File | Settings | File Templates.
 */

class Equipe   {

    protected $comp_id;

    var $competition;

    var $timeschedule;
    var $days;
    var $days_count;
    var $current_day = 0;

    var $startlist;
    var $startlist_riders_count;
    var $current_startlist_rider = 0;

    var $resultlist;
    var $resultlist_riders_count;
    var $current_resultlist_rider = 0;

    var $riders;
    var $current_rider = 0;
    var $riders_count;

    var $horses;
    var $current_horse = 0;
    var $horses_count;

    var $starts;
    var $current_start = 0;
    var $starts_count;

    public function __construct() {
        $this->comp_id = get_option('equipe_api_id');
        $this->competition = $this->get_competition();
    }

    public function get_competition() {

        $get_competition = wp_remote_get('http://online.equipe.com/api/v1/meetings/'.$this->comp_id.'.json');
        $this->competition = json_decode($get_competition['body']);
        return $this->competition;

    }

    public function get_timeschedule() {

        $timeschedule = wp_remote_get('http://online.equipe.com/api/v1/meetings/'.$this->comp_id.'/schedule.json');
        $this->timeschedule = json_decode($timeschedule['body']);
        $this->days = $this->timeschedule->days;
        $this->days_count = count($this->days);

        return $this->timeschedule;

    }

    public function have_days() {

        if ($this->current_day < $this->days_count)
            return true;

        return false;

    }

    public function the_day() {

       return $this->days[$this->current_day++];

    }

    public function get_startlist($class_id) {

        $startlist = wp_remote_get('http://online.equipe.com/api/v1/class_sections/'.$class_id.'/starts.json');
        $this->startlist = json_decode($startlist['body']);
        $this->startlist_riders_count = count($this->startlist);
        return $this->startlist;

    }

    public function startlist_have_riders() {

        if ($this->current_startlist_rider < $this->startlist_riders_count)
            return true;

        return false;

    }

    public function startlist_the_rider() {

        return $this->startlist[$this->current_startlist_rider++];

    }

    public function get_resultlist($class_id) {

        $resultlist = wp_remote_get('http://online.equipe.com/api/v1/class_sections/'.$class_id.'/results.json');
        $this->resultlist = json_decode($resultlist['body']);
        $this->resultlist_riders_count = count($this->resultlist);
        return $this->resultlist;

    }

    public function resultlist_have_riders() {

        if ($this->current_resultlist_rider < $this->resultlist_riders_count)
            return true;

        return false;

    }

    public function resultlist_the_rider() {

        return $this->resultlist[$this->current_resultlist_rider++];

    }

    public function get_riders($meeting_id) {

        $riders = wp_remote_get('http://online.equipe.com/api/v1/meetings/'.$meeting_id.'/riders.json');
        $this->riders = json_decode($riders['body']);
        $this->riders_count = count($this->riders);

        return $this->riders;

    }

    public function have_riders() {
        if ($this->current_rider < $this->riders_count)
            return true;

        return false;

    }

    public function the_rider() {

        return $this->riders[$this->current_rider++];

    }

    public function get_rider($meeting_id, $rider_id) {

        $competition = wp_remote_get('http://online.equipe.com/api/v1/meetings/'.$meeting_id.'/riders/'.$rider_id.'.json');

        return json_decode($competition['body']);

    }

    public function get_horses($meeting_id) {

        $horses = wp_remote_get('http://online.equipe.com/api/v1/meetings/'.$meeting_id.'/horses.json');
        $this->horses = json_decode($horses['body']);
        $this->horses_count = count($this->horses);
        return $this->horses;

    }

    public function have_horses() {
        if ($this->current_horse < $this->horses_count)
            return true;

        $this->current_horse = 0;
        return false;

    }

    public function the_horse() {

        return $this->horses[$this->current_horse++];

    }

    public function get_horse($meeting_id, $horse_id) {

        $this->horses = ($this->horses) ? $this->horses : $this->get_horses($meeting_id);

        $the_horse = false;
        foreach ($this->horses as $horse) {
            if ($horse->id == $horse_id) {
                $the_horse = $horse;
            }
        }

        return $the_horse;

    }


    /*
     $args = array(
        per_page - Antal starter per sida
        page - Aktuell sida
        svrf_no - Klubbens SvRF nummer
        days_ago - Hur många dagar tillbaka
     );
     */
    public function get_club_starts($svrf_nr, $args = '') {

        $starts = wp_remote_get('http://online.equipe.com/api/v1/clubs/'.$svrf_nr.'/starts.json'.$args);

        $this->starts = json_decode($starts['body']);
        $this->starts_count = count($this->starts);

        return $this->starts;

    }

    public function have_starts() {
        if ($this->current_start < $this->starts_count)
            return true;

        return false;

    }

    public function the_start() {

        return $this->starts[$this->current_start++];

    }

}



