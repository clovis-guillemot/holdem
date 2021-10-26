<?php

namespace App\Entity;

use Symfony\Component\Form\Exception\InvalidArgumentException;

class PokerHand
{
    public string $hand;
    private array $face, $flush, $suit, $rank, $flushRank;

    /**
     * @param $hand
     */
    public function __construct($hand)
    {
        $this->hand = $hand;
        $this->generateDeck();
        $this->generateRankings();
    }


    /**
     * Compare current hand with another one,
     * Win should return the integer `1`
     * Loss should return the integer `2`
     * Tie should return the integer `3`
     */
    public function compareWith($hand): int
    {
        $score = $this->evaluate($this->hand);
        $score2 = $this->evaluate($hand);
        if ($score > $score2) {
            return 1;
        } else if ($score < $score2) {
            return 2;
        }
        return 3;
    }

    /**
     * Evaluates 5 cards
     * @param $cards
     * @return int
     */
    private function evaluate($cards): int
    {
        if (is_string($cards)) {
            $cards = Card::parseHand($cards);
        }

        if (count($cards) == 5) {
            return $this->getHandWeight($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]);
        }
        throw new InvalidArgumentException("Must provide either 5 cards");
    }

    /**
     * Gets the weight of a combination of 5 cards.
     */
    private function getHandWeight(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5)
    {
        $w1 = $card1->getWeight();
        $w2 = $card2->getWeight();
        $w3 = $card3->getWeight();
        $w4 = $card4->getWeight();
        $w5 = $card5->getWeight();

        if (($this->suit[$w1] == $this->suit[$w2]) &&
            ($this->suit[$w1] == $this->suit[$w3]) &&
            ($this->suit[$w1] == $this->suit[$w4]) &&
            ($this->suit[$w1] == $this->suit[$w5])) {
            return $this->flushRank[$this->flush[$w1] + $this->flush[$w2] + $this->flush[$w3] + $this->flush[$w4] + $this->flush[$w5]];
        } else {
            return $this->rank[$this->face[$w1] + $this->face[$w2] +
            $this->face[$w3] + $this->face[$w4] +
            $this->face[$w5]];
        }
    }

    /**
     *
     */
    public function generateDeck()
    {
        $this->face = array();
        $this->flush = array();
        $this->suit = array();

        for ($n = 0; $n < 13; $n++) {
            $this->suit[4 * $n] = Constants::SPADE;
            $this->suit[4 * $n + 1] = Constants::HEART;
            $this->suit[4 * $n + 2] = Constants::DIAMOND;
            $this->suit[4 * $n + 3] = Constants::CLUB;

            $this->face[4 * $n] = Constants::FACES[$n];
            $this->face[4 * $n + 1] = Constants::FACES[$n];
            $this->face[4 * $n + 2] = Constants::FACES[$n];
            $this->face[4 * $n + 3] = Constants::FACES[$n];

            $this->flush[4 * $n] = Constants::FLUSHES[$n];
            $this->flush[4 * $n + 1] = Constants::FLUSHES[$n];
            $this->flush[4 * $n + 2] = Constants::FLUSHES[$n];
            $this->flush[4 * $n + 3] = Constants::FLUSHES[$n];
        }
    }


    /**
     *
     */
    private function generateRankings()
    {
        $this->rank = array(Constants::MAX_FIVE_NONFLUSH_KEY_INT + 1);
        $this->flushRank = array(Constants::MAX_FLUSH_KEY_INT + 1);

        $n = 1; // rank number

        for ($i = 0; $i < Constants::MAX_FIVE_NONFLUSH_KEY_INT + 1; $i++) {
            $this->rank[$i] = 0;
        }
        for ($i = 0; $i < Constants::MAX_FLUSH_KEY_INT + 1; $i++) {
            $this->flushRank[$i] = 0;
        }

        //high card
        for ($i = 5; $i <= 12; $i++) {
            for ($j = 3; $j <= $i - 1; $j++) {
                for ($k = 2; $k <= $j - 1; $k++) {
                    for ($l = 1; $l <= $k - 1; $l++) {
                        //no straights
                        for ($m = 0; $m <= $l - 1 && !($i - $m == 4 || ($i == 12 && $j == 3 && $k == 2 && $l == 1 && $m == 0)); $m++) {
                            $this->rank[Constants::FACES[$i] + Constants::FACES[$j] + Constants::FACES[$k] + Constants::FACES[$l] + Constants::FACES[$m]] = $n;
                            $n++;
                        }
                    }
                }
            }
        }

        //pair
        for ($i = 0; $i <= 12; $i++) {
            for ($j = 2; $j <= 12; $j++) {
                for ($k = 1; $k <= $j - 1; $k++) {
                    for ($l = 0; $l <= $k - 1; $l++) {
                        if ($i != $j && $i != $k && $i != $l) {
                            $this->rank[(2 * Constants::FACES[$i]) + Constants::FACES[$j] + Constants::FACES[$k] + Constants::FACES[$l]] = $n;
                            $n++;
                        }
                    }
                }
            }
        }

        //2pair
        for ($i = 1; $i <= 12; $i++) {
            for ($j = 0; $j <= $i - 1; $j++) {
                for ($k = 0; $k <= 12; $k++) {
                    //no fullhouse
                    if ($k != $i && $k != $j) {
                        $this->rank[(2 * Constants::FACES[$i]) + (2 * Constants::FACES[$j]) + Constants::FACES[$k]] = $n;
                        $n++;
                    }
                }
            }
        }

        //triple
        for ($i = 0; $i <= 12; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                for ($k = 0; $k <= $j - 1; $k++) {
                    //$no quad
                    if ($i != $j && $i != $k) {
                        $this->rank[(3 * Constants::FACES[$i]) + Constants::FACES[$j] + Constants::FACES[$k]] = $n;
                        $n++;
                    }
                }
            }
        }

        //low straight nonflush
        $this->rank[Constants::FACES[12] + Constants::FACES[0] + Constants::FACES[1] + Constants::FACES[2] + Constants::FACES[3]] = $n;
        $n++;

        //usual straight nonflush
        for ($i = 0; $i <= 8; $i++) {
            $this->rank[Constants::FACES[$i] + Constants::FACES[$i + 1] + Constants::FACES[$i + 2] + Constants::FACES[$i + 3] + Constants::FACES[$i + 4]] = $n;
            $n++;
        }

        //flush not a straight
        for ($i = 5; $i <= 12; $i++) {
            for ($j = 3; $j <= $i - 1; $j++) {
                for ($k = 2; $k <= $j - 1; $k++) {
                    for ($l = 1; $l <= $k - 1; $l++) {
                        for ($m = 0; $m <= $l - 1; $m++) {
                            if (!($i - $m == 4 || ($i == 12 && $j == 3 && $k == 2 && $l == 1 && $m == 0))) {
                                $this->flushRank[Constants::FLUSHES[$i] + Constants::FLUSHES[$j] + Constants::FLUSHES[$k] +
                                Constants::FLUSHES[$l] + Constants::FLUSHES[$m]] = $n;
                                $n++;
                            }
                        }
                    }
                }
            }
        }

        //full house
        for ($i = 0; $i <= 12; $i++)
            for ($j = 0; $j <= 12; $j++) {
                if ($i != $j) {
                    $this->rank[(3 * Constants::FACES[$i]) + (2 * Constants::FACES[$j])] = $n;
                    $n++;
                }
            }

        //quad
        for ($i = 0; $i <= 12; $i++) {
            for ($j = 0; $j <= 12; $j++) {
                if ($i != $j) {
                    $this->rank[(4 * Constants::FACES[$i]) + Constants::FACES[$j]] = $n;
                    $n++;
                }
            }
        }

        //low straight flush
        $this->flushRank[Constants::FLUSHES[0] + Constants::FLUSHES[1] + Constants::FLUSHES[2] + Constants::FLUSHES[3] + Constants::FLUSHES[12]] = $n;
        $n++;

        //usual straight flush
        for ($i = 0; $i <= 8; $i++) {
            $this->flushRank[Constants::FLUSHES[$i] + Constants::FLUSHES[$i + 1] + Constants::FLUSHES[$i + 2] +
            Constants::FLUSHES[$i + 3] + Constants::FLUSHES[$i + 4]] = $n;
            $n++;
        }
    }
}