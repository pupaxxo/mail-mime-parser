<?php
namespace ZBateson\MailMimeParser\Header\Part;

use PHPUnit_Framework_TestCase;

/**
 * Description of CommentTest
 *
 * @group HeaderParts
 * @group CommentPart
 * @covers ZBateson\MailMimeParser\Header\Part\CommentPart
 * @covers ZBateson\MailMimeParser\Header\Part\HeaderPart
 * @author Zaahid Bateson
 */
class CommentPartTest extends PHPUnit_Framework_TestCase
{
    private $charsetConverter;
    
    public function setUp()
    {
        $this->charsetConverter = $this->getMock('ZBateson\MailMimeParser\Util\CharsetConverter');
    }
    
    public function testBasicComment()
    {
        $comment = 'Some silly comment made about my moustache';
        $part = new CommentPart($this->charsetConverter, $comment);
        $this->assertEquals('', $part->getValue());
        $this->assertEquals($comment, $part->getComment());
    }
    
    public function testMimeEncoding()
    {
        $this->charsetConverter->expects($this->once())
            ->method('convert')
            ->with('Kilgore Trout', 'US-ASCII', 'UTF-8')
            ->willReturn('Kilgore Trout');
        $part = new CommentPart($this->charsetConverter, '=?US-ASCII?Q?Kilgore_Trout?=');
        $this->assertEquals('', $part->getValue());
        $this->assertEquals('Kilgore Trout', $part->getComment());
    }
}
