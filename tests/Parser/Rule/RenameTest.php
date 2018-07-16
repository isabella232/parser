<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 15-7-18
 * Time: 21:27
 */

namespace Dutchlabelshop\Parser\Rule;

use Dutchlabelshop\Parser\Context;
use Dutchlabelshop\Parser\Matcher\IsExact;
use Dutchlabelshop\Parser\Matcher\IsTrue;
use PHPUnit\Framework\TestCase;

class RenameTest extends TestCase
{

    public function testMatcher()
    {
        $rule = new Rename('test2');
        $this->assertInstanceOf(IsTrue::class, $rule->getMatcher());

        $rule = new Rename('test2', new IsExact('test'));
        $this->assertInstanceOf(IsExact::class, $rule->getMatcher());
    }

    public function testExecute()
    {
        $root = ['test' => 'text'];
        $context = new Context($root);

        $rule = new Rename('test2');

        $this->assertTrue($rule->execute($context));
        $this->assertSame(['test2' => 'text'], $context->getRoot());
        $this->assertTrue($context->isChanged());
    }

}