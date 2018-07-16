<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 16-7-18
 * Time: 13:09
 */

namespace Elgentos\Parser;

use Elgentos\Parser\Interfaces\RuleInterface;
use PHPUnit\Framework\TestCase;

class StoryTest extends TestCase
{

    /** @var Context */
    private $context;

    public function setUp()
    {
        $root = [];
        $this->context = new Context($root);
    }

    public function testOneStory()
    {
        $context = $this->context;

        $ruleMock = $this->getMockBuilder(RuleInterface::class)
                ->getMock();

        $ruleMock->expects($this->once())
                ->method('parse')
                ->willReturn(true);

        $story = new Story($ruleMock);

        $this->assertTrue($story->match($context));
        $this->assertTrue($story->parse($context));
    }

    public function testTwoStories()
    {
        $context = $this->context;

        $ruleMock = $this->getMockBuilder(RuleInterface::class)
                ->getMock();

        $ruleMock->expects($this->exactly(2))
                ->method('parse')
                ->willReturn(true);

        $story = new Story($ruleMock, $ruleMock);

        $this->assertTrue($story->parse($context));
    }

    public function testCounters()
    {
        $context = $this->context;

        $ruleMock = $this->getMockBuilder(RuleInterface::class)
                ->getMock();

        $ruleMock->expects($this->exactly(10))
                ->method('parse')
                ->willReturn(
                        true, false, true, false, true,
                        true, false, true, false, true
                );

        $story = new Story($ruleMock, $ruleMock, $ruleMock, $ruleMock, $ruleMock);

        $this->assertTrue($story->parse($context));
        $this->assertSame(3, $story->getSuccessful());
        $this->assertSame(5, $story->getTotal());

        $this->assertTrue($story->parse($context));
        $this->assertSame(6, $story->getSuccessful());
        $this->assertSame(10, $story->getTotal());
    }

}
