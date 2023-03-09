<?php
namespace Checkin;

require('../classes/Checkin/CheckInReport.class.php');
require('../classes/Checkin/CheckInList.class.php');
require('../classes/Checkin/CheckIn.class.php');
require('../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

final class CheckinListTest extends TestCase
{ 
    public function testClassConstructor()
    {
 
        $CheckInReport = new CheckInReport('../data/applications_one.csv');
        $CheckInList = $CheckInReport->CheckInList;
        $this->assertSame(1, sizeof($CheckInList->CheckIns));

        $CheckInReport = new CheckInReport('../data/applications_mini.csv');
        $CheckInList = $CheckInReport->CheckInList;
        $this->assertSame(10, sizeof($CheckInList->CheckIns));        
    }

}