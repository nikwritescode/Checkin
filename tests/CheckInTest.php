<?php
namespace Checkin;

require('../classes/Checkin/CheckIn.class.php');
require('../vendor/autoload.php');


use PHPUnit\Framework\TestCase;

final class CheckinTest extends TestCase
{ 

    public function testClassConstructor()
    {
        $DateTime = \DateTimeImmutable::createFromFormat('d/m/Y H:i', '29/05/2023 11:00');
        $CheckIn = new CheckIn(1,'Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00',89);
    
        $this->assertSame(1, $CheckIn->tenant_id);
        $this->assertSame('Karina', $CheckIn->first_name);
        $this->assertSame('Diggle', $CheckIn->last_name);
        $this->assertSame('kdiggle0@cloudflare.com', $CheckIn->email);
        $this->assertSame($DateTime->format('d/m/Y H:i'), $CheckIn->date->format('d/m/Y H:i'));
        $this->assertSame(89, $CheckIn->property_id);
        $this->assertNull($CheckIn->employee_id);              
    }


    public function testGetDate()
    {
        $DateTime = \DateTimeImmutable::createFromFormat('d/m/Y H:i', '29/05/2023 11:00');
        $CheckIn = new CheckIn(1,'Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00',89);
        
        $this->assertSame($DateTime->format('d/m/Y H:i'), $CheckIn->getDate('d/m/Y H:i'));
        $this->assertSame($DateTime->format('t'), $CheckIn->getDate('t'));
    }


    public function testIsLastDayOfMonth()
    {
        $CheckIn = new CheckIn(1,'Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00',89);
        
        $this->assertFalse($CheckIn->isLastDayOfMonth());

        $CheckIn = new CheckIn(2,'Lovell','Spreadbury','lspreadbury1@feedburner.com',
                                        '(878) 1330545','28/02/2023','12:00',35);
        
        $this->assertTrue($CheckIn->isLastDayOfMonth());        
    }

    
    public function testSetFailureReason()
    {
        $CheckIn = new CheckIn(2,'Lovell','Spreadbury','lspreadbury1@feedburner.com',
                                        '(878) 1330545','28/02/2023','12:00',35);

        $CheckIn->setFailureReason('Falls on the end of the month');

        $this->assertSame($CheckIn->message, 'Falls on the end of the month');

    }

    public function testSatisfy()
    {

        $CheckIn = new CheckIn(1,'Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00',89);
        
        $CheckIn->satisfy(1);

        $this->assertSame($CheckIn->employee_id,1);
        $this->assertSame($CheckIn->satisfied,true);

    }
    
    
    public function testIsSatisfied()
    {
        $CheckIn = new CheckIn(1,'Karina','Diggle','kdiggle0@cloudflare.com',
                                        '(183) 7239797','29/05/2023','11:00',89);
        
        $CheckIn->satisfy(1);

        $this->assertSame($CheckIn->employee_id,1);
        $this->assertSame($CheckIn->isSatisfied(),true);
        $this->assertSame($CheckIn->satisfied,$CheckIn->isSatisfied());
    }
    

}