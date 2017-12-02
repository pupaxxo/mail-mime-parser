<?php
namespace ZBateson\MailMimeParser\Header\Consumer;

use PHPUnit_Framework_TestCase;
use DateTime;

/**
 * Description of DateConsumerTest
 *
 * @group Consumers
 * @group DateConsumer
 * @covers ZBateson\MailMimeParser\Header\Consumer\DateConsumer
 * @covers ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer
 * @author Zaahid Bateson
 */
class DateConsumerTest extends PHPUnit_Framework_TestCase
{
    private $dateConsumer;
    
    protected function setUp()
    {
        $charsetConverter = $this->getMock('ZBateson\MailMimeParser\Util\CharsetConverter', ['__toString']);
        $pf = $this->getMock('ZBateson\MailMimeParser\Header\Part\HeaderPartFactory', ['__toString'], [$charsetConverter]);
        $mlpf = $this->getMock('ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory', ['__toString'], [$charsetConverter]);
        $cs = $this->getMock('ZBateson\MailMimeParser\Header\Consumer\ConsumerService', ['__toString'], [$pf, $mlpf]);
        $this->dateConsumer = new DateConsumer($cs, $pf);
    }
    
    public function testConsumeDates()
    {
        $date = 'Wed, 17 May 2000 19:08:29 -0400';
        $ret = $this->dateConsumer->__invoke($date);
        $this->assertNotEmpty($ret);
        $this->assertCount(1, $ret);
        $this->assertInstanceOf('\ZBateson\MailMimeParser\Header\Part\DatePart', $ret[0]);
        $this->assertEquals($date, $ret[0]->getValue());
        $this->assertEquals($date, $ret[0]->getDateTime()->format(DateTime::RFC2822));
    }
    
    public function testConsumeDateWithComment()
    {
        $dateTest = 'Wed, 17 May 2000 19:08:29 -0400 (some comment)';
        $actDate = 'Wed, 17 May 2000 19:08:29 -0400';
        $ret = $this->dateConsumer->__invoke($dateTest);
        $this->assertNotEmpty($ret);
        $this->assertCount(1, $ret);
        $this->assertEquals($actDate, $ret[0]->getValue());
        $this->assertEquals($actDate, $ret[0]->getDateTime()->format(DateTime::RFC2822));
    }
}
