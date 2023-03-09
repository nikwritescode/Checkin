<?php
/** 
 * Contains the CheckIn class
 * 
 * @author  Nik Johnson
 * @version 1.0
*/
namespace Checkin;

define('DATE_FORMAT','d/m/Y H:i');


 /**
  * CheckIn Class
  *
  * Responsible for looking after individual check in visits
  *
  */
class CheckIn
{
    public $employee_id = null;

    /** 
     * Constructor
     * 
     * @param int      $tenant_id       ID of the tenant
     * @param string   $first_name      Tenant's first name
     * @param string   $last_name       Tenant's last name
     * @param string   $email           Tenant's email address
     * @param string   $telephone       Tenant's telephone number
     * @param string   $date            Date of visit formatted per DATE_FORMAT
     * @param string   $time            Time of visit formatted per DATE_FORMAT
     * @param int      $property_id     ID of the property to visit
     *      
    */    
    function __construct($tenant_id,$first_name,$last_name,$email,$telephone,$date,$time,$property_id)
    {
        $this->tenant_id = $tenant_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->date = \DateTimeImmutable::createFromFormat(DATE_FORMAT, $date . ' ' . $time);
        $this->property_id = $property_id;
        $this->satisfied = false;
    }

    /** 
     * Returns the checkin date in a format of your choice
     * 
     * @param  string $format (optional) Format of date to be returned 
     * @return string                    Date and time in the format specified 
     * @access public 
    */       
    public function getDate($format = DATE_FORMAT)
    {
        return $this->date->format($format);
    }

    /** 
     * Is this checkin on the last day of the month?
     * 
     * @return bool     Is this checkin on the last day of the month?
     * @access public 
    */
    public function isLastDayOfMonth()
    {
        return $this->getDate('t') == $this->getDate('d');
    }

    /** 
     * Add a failure reason to the checkin
     * 
     * @param  string $message Message to be added 
     * @access public 
    */      
    function setFailureReason($message)
    {
        $this->message = $message;
    }

    /** 
     * Allocate an employee to this checkin
     * 
     * @param  int     $employee_id ID of the employee to attach 
     * @access private 
    */     
    private function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;        
    }

     /** 
     * Acknowledge that this checkin has passed checks and assign
     * 
     * @param  int     $employee_id ID of the employee to attach 
     * @access public 
    */
    public function satisfy($employee_id)
    {
        $this->setEmployeeId($employee_id);
        $this->satisfied = true;
    }

    /** 
     * Does this checkin satisfy all the date and time rules?
     * 
     * @return bool     Has this checkin passed the checks?
     * @access public 
    */
    public function isSatisfied()
    {
        return $this->satisfied;
    }
}