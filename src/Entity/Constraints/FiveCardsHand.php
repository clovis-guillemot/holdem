<?php

namespace App\Entity\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FiveCardsHand extends Constraint
{
    public $message = '{{ hand }} must contain 5 cards. 
        Space must be used as card separator. 
        Each card consists of 2 characters.
        First is face: `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `T`(en), `J`(ack), `Q`(ueen), `K`(ing), `A`(ce).
        Second is suit: `S`(pades), `H`(earts), `D`(iamonds), `C`(lubs).';

}