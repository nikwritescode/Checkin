<?php
/** 
 * Contains the sole endpoint for this API
 * 
 * @author  Nik Johnson
 * @version 1.0
*/
namespace Checkin;

spl_autoload_register(function ($class_name) {
    include 'classes/'. $class_name . '.class.php';
});

define('MAXIMUM_EMPLOYEES','3');
define('CSV_FILE','data/applications.csv');

$CheckInReport = new CheckInReport(CSV_FILE);

echo $CheckInReport->checkInReport();
