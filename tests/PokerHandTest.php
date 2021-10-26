<?php

namespace App\Tests;

use App\Entity\PokerHand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class PokerHandTest extends TestCase
{

    /**
     * Test Win.
     */
    public function testCompareWithWin(): void
    {
        $hand = new PokerHand("AS 2H 5C JD JC");
        $this->assertSame(1, $hand->compareWith("KS 2H 5C JD TD"));
    }

    /**
     * Test Lose.
     */
    public function testCompareLose(): void
    {
        $hand = new PokerHand("KS 2H 5C JD TD");
        $this->assertSame(2, $hand->compareWith("AS 2H 5C JD JC"));
    }

    /**
     * Test Tie.
     */
    public function testCompareWithTie(): void
    {
        $hand = new PokerHand("KS 2H 5C JD TD");
        $this->assertSame(3, $hand->compareWith("KS 2H 5C JD TD"));
    }
}