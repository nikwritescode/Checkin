<?php
/** 
 * Contains the CheckInReport class
 * 
 * @author  Nik Johnson
 * @version 1.0
*/
namespace Checkin;

 /**
  * CheckInReport Class
  *
  * Responsible for parsing checkin data and generating reports
  *
  */
class CheckInReport
{
   /** 
     * Generates a report of checkin data from CheckIns
     * 
     * @param  string   $csv_file   CSV file of checkin data
     * @access public 
    */       
    function __construct($csv_file)
    {
        $handle = fopen($csv_file, "r");
        $checkins = array_map('str_getcsv', file($csv_file));
        fclose($handle);
        $this->CheckInList = new CheckInList($checkins);
    }

   /** 
     * Generates a report of checkin data from CheckIns
     * 
     * @return string CSV formatted string 
     * @access public 
    */      
    function checkInReport()
    {
        $output = '';
        $employeeCount = 1;
        while($employeeCount <= MAXIMUM_EMPLOYEES)
        {
            $this->Employees[$employeeCount] = new Employee($employeeCount);
            $employeeCount++;
        }
        
        $output .= "tenant_id,employee_id,satisfied,message\r\n";

        foreach($this->CheckInList->CheckIns as $CheckIn)
        {            
            $CheckInSatisfied = false;

            if($CheckIn->isLastDayOfMonth())
            {
                $CheckIn->setFailureReason($CheckIn->getDate() . ' falls on the end of the month');
            } 
            else
            {
                foreach($this->Employees as $employee_id => &$Employee)
                {
                    if($Employee->isFree($CheckIn->date))
                    {
                        $Employee->allocateCheckIn($CheckIn);
                        $CheckIn->satisfy($employee_id);
                        $CheckInSatisfied = true;
                        break;
                    }
                }
                if(!$CheckInSatisfied)
                {
                    $CheckIn->setFailureReason('No employees free on ' . $CheckIn->getDate());                   
                }
            }        

            $output .= $CheckIn->tenant_id . ',' . $CheckIn->employee_id . ',';

            if($CheckIn->isSatisfied())
            {
                $output .= "true\n";
            }
            else
            {
                $output .= 'false,"' . $CheckIn->message . "\"\n";
            }
        }

        return $output;
    }

}