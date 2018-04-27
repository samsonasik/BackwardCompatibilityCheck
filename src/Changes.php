<?php

declare(strict_types=1);

namespace Roave\ApiCompare;

use ArrayIterator;
use Assert\Assert;
use Countable;
use IteratorAggregate;
use function array_merge;
use function count;

final class Changes implements IteratorAggregate, Countable
{
    /** @var Change[] */
    private $changes = [];

    private function __construct()
    {
    }

    public static function empty() : self
    {
        return new self();
    }

    public static function fromList(Change ...$changes) : self
    {
        $instance = new self();

        $instance->changes = $changes;

        return $instance;
    }

    public function mergeWith(self $other) : self
    {
        if (empty($other->changes)) {
            return $this;
        }

        $instance = new self();

        $instance->changes = array_merge($this->changes, $other->changes);

        return $instance;
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayIterator|Change[]
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->changes);
    }

    /**
     * {@inheritDoc}
     */
    public function count() : int
    {
        return count($this->changes);
    }
}
