<?php

namespace App\Entity;

/**
 * Each card consists of two characters (Face and Suit) and a Weight.
 */
class Card
{
    /**
     * The first character is the value of the card,
     * valid characters are: `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `T`(en), `J`(ack), `Q`(ueen), `K`(ing), `A`(ce)
     * @var int[]
     */
    private static array $faces = array(
        'A' => 0, 'K' => 1, 'Q' => 2, 'J' => 3,
        'T' => 4, '9' => 5, '8' => 6, '7' => 7,
        '6' => 8, '5' => 9, '4' => 10, '3' => 11,
        '2' => 12
    );
    /**
     * The second character represents the suit,
     * valid characters are: `S`(pades), `H`(earts), `D`(iamonds), `C`(lubs)
     * @var int[]
     */
    private static array $suits = array(
        'S' => 0, 'H' => 1, 'D' => 2, 'C' => 3
    );

    private string $face, $suit;
    private int $weight;

    /**
     * Constructor
     * @param string the string value of the hand
     */
    public function __construct($str)
    {
        $this->face = $str[0];
        $this->suit = strtoupper($str[1]); // suit always uppercase
        $this->weight = $this->calculateWeight();
    }

    /**
     * Parse a string into an array of cards.
     * @param string $str
     * @return array
     */
    public static function parseHand(string $str): array
    {
        $hand = array();

        foreach (explode(' ', $str) as $card)
            $hand[] = new self($card);

        return $hand;
    }

    /**
     * Calculate the Weight of the card.
     * @return float|int equal to 4*Face+Suit
     */
    private function calculateWeight()
    {
        return (4 * self::$faces[$this->face]) + self::$suits[$this->suit];
    }

    /**
     * Returns an integer for the card, in descending value from 0 to 51, from AS - 2C
     */
    public function getWeight()
    {
        return $this->weight;
    }

    public function getFace()
    {
        return $this->face;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
}