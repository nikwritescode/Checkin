<?php
namespace Checkin;

require('../classes/Checkin/Employee.class.php');
require('../classes/Checkin/CheckIn.class.php');
require('../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

final class EmployeeTest extends TestCase
{ 
    public function testClassConstructor()
    {
        $Employee = new \Checkin\Employee(1);
    
        $this->assertSame(1, $Employee->employee_id);
        $this->assertEmpty($Employee->busy_times);

    }

    public function testIsFree()
    {
        $Employee = new \Checkin\Employee(1);
        $DateTime = \DateTimeImmutable::createFromFormat('d/m/Y H:i', '29/05/2023 11:00');
        $this->assertTrue($Employee->isFree($DateTime));
    }

    public function testAllocateCheckIn()
    {
        $Employee = new \Checkin\Employee(1);
        $DateTime = \DateTimeImmutable::createFromFormat('d/m/Y H:i', '29/05/2023 11:00');
        $this->assertTrue($Employee->isFree($DateTime));

        $CheckIn = new \Checkin\CheckIn('1','Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00','89');

        $Employee->allocateCheckIn($CheckIn);
        
        $this->assertFalse($Employee->isFree($DateTime));        
    }

}