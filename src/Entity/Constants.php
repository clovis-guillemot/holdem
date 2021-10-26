<?php

namespace App\Entity;

class Constants
{
    // SUITS
    const SPADE = 0;
    const HEART = 1;
    const DIAMOND = 8;
    const CLUB = 57;

    // FACES
    const TWO = 0;
    const THREE = 1;
    const FOUR = 5;
    const FIVE = 22;
    const SIX = 94;
    const SEVEN = 312;
    const EIGHT = 992;
    const NINE = 2422;
    const TEN = 5624;
    const JACK = 12522;
    const QUEEN = 19998;
    const KING = 43258;
    const ACE = 79415;

    const FACES = array(self::ACE, self::KING, self::QUEEN, self::JACK,
        self::TEN, self::NINE, self::EIGHT, self::SEVEN,
        self::SIX, self::FIVE, self::FOUR, self::THREE,
        self::TWO
    );

    // FLUSHES
    const TWO_FLUSH = 1;
    const THREE_FLUSH = 2;
    const FOUR_FLUSH = 4;
    const FIVE_FLUSH = 8;
    const SIX_FLUSH = 16;
    const SEVEN_FLUSH = 32;
    const EIGHT_FLUSH = 64;
    const NINE_FLUSH = 128; // 64+32+16+8+4+2+1+1;
    const TEN_FLUSH = 255; // 128+64+32+16+8+4+2+1;
    const JACK_FLUSH = 508; // 255+128+64+32+16+8+4+1;
    const QUEEN_FLUSH = 1012; // 508+255+128+64+32+16+8+1;
    const KING_FLUSH = 2016; // 1012+508+255+128+64+32+16+1;
    const ACE_FLUSH = 4016; // 2016+1012+508+255+128+64+32+1

    const FLUSHES = array(
        self::ACE_FLUSH, self::KING_FLUSH, self::QUEEN_FLUSH, self::JACK_FLUSH,
        self::TEN_FLUSH, self::NINE_FLUSH, self::EIGHT_FLUSH, self::SEVEN_FLUSH,
        self::SIX_FLUSH, self::FIVE_FLUSH, self::FOUR_FLUSH, self::THREE_FLUSH,
        self::TWO_FLUSH
    );

    const MAX_FIVE_NONFLUSH_KEY_INT = 360918; // 4*ACE+KING;

    const MAX_FLUSH_KEY_INT = 7999; // ACE_FLUSH+KING_FLUSH+QUEEN_FLUSH+JACK_FLUSH+TEN_FLUSH+NINE_FLUSH+EIGHT_FLUSH;
}