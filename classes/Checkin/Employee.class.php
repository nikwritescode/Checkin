<?php
/** 
 * Contains the Employee class
 * 
 * @author  Nik Johnson
 * @version 1.0
*/

namespace Checkin;

define('VISIT_TIME_MINUTES',60);
define('TRAVEL_TIME_MINUTES',30);

 /**
  * Employee Class
  *
  * Responsible for looking after Employees and tracking their availability
  *
  */
class Employee
{

    var $employee_id;
    var $busy_times = array();

    /** 
     * Constructor
     * 
     * @param int $employee_id ID of the employee 
    */
    function __construct($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    /** 
     * Is this employee free to work on the given date and time
     * 
     * @param DateTimeImmutable $dateTime DateTimeImmutable Object with the timestamp of the visit 
     * @return bool Whether the employee is free on that date / time 
     * @access public 
    */    
    public function isFree(\DateTimeImmutable $dateTime)
    {

        $visitTimes = $this->getVisitTimes($dateTime);
        
        if (empty($this->busy_times)) 
        {
            return true;
        }

        foreach($this->busy_times as $busyTime)
        {
            if( 
                  ($visitTimes['start'] >= $busyTime['start'] && $visitTimes['start'] <= $busyTime['end'])
               || ($visitTimes['end']   >= $busyTime['start'] && $visitTimes['end']   <= $busyTime['end'])
            )
            {
                return false;
            }
        }
    
        return true;
    }

    /** 
     * Allocates a check-in job to this Employee
     * 
     * @param CheckIn $CheckIn CheckIn object 
     * @access public 
    */    
    public function allocateCheckIn(CheckIn $CheckIn)
    {
        $visitTimes = $this->getVisitTimes($CheckIn->date);
        $this->busy_times[] = array( 'start'=>$visitTimes['start'],
                                    'end'=>$visitTimes['end'],
                                    'tenant_id' => $CheckIn->tenant_id);

    }

    /** 
     * Calculates the entire duration of a visit
     * 
     * @param DateTimeImmutable $dateTime DateTimeImmutable Object with the timestamp of the visit 
     * @return array  Array containing DateTimeImmutable Objects with the start and end times.
     *      [
     *      'start'        => DateTimeImmutable
     *      'end'          => DateTimeImmutable
     *      ]
     * @access private
     */
    private function getVisitTimes(\DateTimeImmutable $dateTime)
    {
        $startInterval = new \DateInterval('PT' . TRAVEL_TIME_MINUTES . 'M');
        $startTime = clone $dateTime;
        $startTime->sub($startInterval);
    
        $endInterval = new \DateInterval('PT' . VISIT_TIME_MINUTES . 'M');
        $endTime = clone $dateTime;
        $endTime->add($endInterval);
    
        return array('start' => $startTime, 'end' => $endTime);
    }
}