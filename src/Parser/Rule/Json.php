<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-7-18
 * Time: 14:25
 */

namespace Elgentos\Parser\Rule;

use Elgentos\Parser\Context;
use Elgentos\Parser\Interfaces\RuleInterface;

class Json implements RuleInterface
{

    public function parse(Context $context): bool
    {
        $jsonData = $context->getCurrent();

        $current = &$context->getCurrent();
        $current = json_decode($jsonData, true);
        $context->changed();

        return true;
    }

}
