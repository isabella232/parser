<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 15-7-18
 * Time: 2:04
 */

namespace Dutchlabelshop\Parser\Rule;

use Dutchlabelshop\Parser\Context;
use Dutchlabelshop\Parser\Matcher\IsFalse;
use Dutchlabelshop\Parser\Matcher\IsTrue;
use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{

    /** @var Context */
    private $context;

    public function setUp()
    {
        $root = [
                "
                
                remove all space\t
                
                ",
                "ddddcharlistddd"
        ];
        $this->context = new Context($root);
    }

    public function testExecute()
    {
        $context = $this->context;

        $rule = new Trim;
        $test = trim($context->getCurrent());

        $rule->execute($context);
        $this->assertSame($test, $context->getCurrent());
    }

    public function testCharlist()
    {
        $context = $this->context;
        $context->setIndex('1');

        $rule = new Trim(new IsTrue, 'd');
        $test = trim($context->getCurrent(), 'd');

        $rule->execute($context);
        $this->assertSame($test, $context->getCurrent());
    }

    public function testGetMatcher()
    {
        $rule = new Trim;
        $this->assertInstanceOf(IsTrue::class, $rule->getMatcher());

        $rule = new Trim(new IsFalse);
        $this->assertInstanceOf(IsFalse::class, $rule->getMatcher());
    }
}