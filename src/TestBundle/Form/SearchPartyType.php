<?php
namespace TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{SearchType, SubmitType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\{Length, NotBlank};

class SearchPartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', SearchType::class, [
                'label' => 'Wyszukaj swoje wydarzenie:',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 1, 'max' => 50]),
                ]
            ])
            ->add('Szukaj', SubmitType::class);
    }
}