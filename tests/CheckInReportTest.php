<?php
namespace Checkin;

require('../classes/Checkin/CheckInReport.class.php');
require('../classes/Checkin/CheckInList.class.php');
require('../classes/Checkin/CheckIn.class.php');
require('../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

final class CheckInReportTest extends TestCase
{ 
    /** @test */
    public function testClassConstructor()
    {
        $CheckInReport = new CheckInReport('../data/applications_one.csv');
        $this->assertSame(1, sizeof($CheckInReport->CheckInList->CheckIns));
    }

}