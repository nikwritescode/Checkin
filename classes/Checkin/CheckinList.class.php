<?php
/** 
 * Contains the CheckInList class
 * 
 * @author  Nik Johnson
 * @version 1.0
*/

namespace Checkin;

 /**
  * CheckInList Class
  *
  * Responsible for looking after a collection of checkins
  *
  */
class CheckInList
{
    /**
     * An array to be filled with CheckIn objects
     *
     * @var array
     */    
    var $CheckIns = array();


    /** 
     * Constructor
     * 
     * @param array    $csvData         CSV checkin data, with the following fields
     *      $params = [
     *                  @param int      $tenant_id       Tenant's ID
     *                  @param string   $first_name      Tenant's first name
     *                  @param string   $last_name       Tenant's last name
     *                  @param string   $email           Tenant's email address
     *                  @param string   $telephone       Tenant's telephone number
     *                  @param string   $date            Date of visit formatted per DATE_FORMAT
     *                  @param string   $time            Time of visit formatted per DATE_FORMAT
     *                  @param int      $property_id     ID of the property to visit
     *                ]
     *      
    */     
    function __construct($csvData)
    {

        foreach($csvData as $row)
        {
            $this->addCheckIn(  $row[0],
                                $row[1],
                                $row[2],                                                
                                $row[3],                                
                                $row[4],
                                $row[5],
                                $row[6],
                                $row[7]
                            );                                
          
        }
    }

    /** 
     * Add a checkin to the list
     * 
     *  @param int      $tenant_id       Tenant's ID
     *  @param string   $first_name      Tenant's first name
     *  @param string   $last_name       Tenant's last name
     *  @param string   $email           Tenant's email address
     *  @param string   $telephone       Tenant's telephone number
     *  @param string   $date            Date of visit formatted per DATE_FORMAT
     *  @param string   $time            Time of visit formatted per DATE_FORMAT
     *  @param int      $property_id     ID of the property to visit
     * @access private 
    */  
    private function addCheckIn($tenant_id,$first_name,$last_name,$email,$telephone,$date,$time,$property_id)
    {        
        $this->CheckIns[] = new CheckIn($tenant_id,$first_name,$last_name,$email,$telephone,$date,$time,$property_id);
        
    }

}