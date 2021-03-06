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

class LoopAll implements RuleInterface
{

    /** @var RuleInterface[] */
    private $rules;

    public function __construct(RuleInterface ...$rules)
    {
        if (\func_num_args() < 2) {
            throw new \InvalidArgumentException("Should at least have two rules");
        }

        $this->rules = $rules;
    }

    public function parse(Context $context): bool
    {
        while (true) {
            foreach ($this->rules as $rule) {
                if (! $rule->parse($context)) {
                    // Stop if a rule fails
                    break 2;
                }
            }
        }

        return false;
    }
}
