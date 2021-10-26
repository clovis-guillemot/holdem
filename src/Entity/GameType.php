<?php

namespace App\Entity;

use App\Entity\Constraints\FiveCardsHand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $validator = new FiveCardsHand();
        $builder
            ->add('handA', TextType::class, [
                'label' => 'First Hand',
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'constraints' => [
                   $validator,
                ],
            ])
            ->add('handB', TextType::class, [
                'label' => 'Second Hand',
                'row_attr' => [
                    'class' => 'mb-3',
                ],
                'constraints' => [
                    $validator,
                ],
            ])
            ->add('compare', SubmitType::class, ['label' => 'Compare']);
    }
}