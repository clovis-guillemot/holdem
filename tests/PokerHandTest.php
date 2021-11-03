<?php

namespace App\Tests;

use App\Entity\PokerHand;
use PHPUnit\Framework\TestCase;

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

    /**
     * Test One Pair / Two Pair.
     */
    public function testOnePairTwoPair(): void
    {
        $hand = new PokerHand("AS 2H 5H TH TD"); // One Pair of Ten
        $this->assertSame(2, $hand->compareWith("JH 5C 5S 7H 7D")); // Two Pairs
    }
}