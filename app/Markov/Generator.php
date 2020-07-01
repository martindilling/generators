<?php
declare(strict_types=1);

namespace App\Markov;

use Scriptura\Markov\Chain;

class Generator
{
    private int $order;

    /** @var Chain[] */
    private array $chains = [];

    /**
     * @param string[] $dictionary
     * @param int $order
     */
    public function __construct(array $dictionary, int $order)
    {
        $this->order = $order;

        for ($i = $order; $i >= 1; $i--) {
            $this->chains[$i] = new Chain($i);
            foreach ($dictionary as $word) {
                $this->chains[$i]->learn(mb_str_split(mb_strtolower($word)));
            }
        }
    }

    public function generate() : string
    {
        $name = [];
        $state = array_fill(0, $this->chains[$this->order]->order(), '');
        $stop = false;

        while (!$stop) {
            $link = $this->chains[$this->order]->find($state);
            $last = $link->next();
            $name[] = $last;

            // Remove head from state
            array_shift($state);
            // Push next to tail of state
            $state[] = $last;

            if ($last === '') {
                $stop = true;
            }
        }

        return implode('', $name);
    }
}
