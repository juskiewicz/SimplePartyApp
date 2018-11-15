<?php
namespace TestBundle\Form;

use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface,
    FormEvent,
    FormEvents,
    FormError
};
use Symfony\Component\Form\Extension\Core\Type\{
    DateTimeType,
    EmailType,
    TextType,
    TextareaType,
    SubmitType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Juskiewicz\Geolocation\Geolocation;

class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa:'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis:'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adres:'
            ])
            ->add('fromAt', DateTimeType::class, [
                'label' => 'Od:'
            ])
            ->add('toAt', DateTimeType::class, [
                'label' => 'Do:'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:'
            ])
            ->add('Zapisz', SubmitType::class)
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                /* @var \TestBundle\Entity\Party $party */
                $party = $event->getData();
                $form = $event->getForm();

                if (!$party->getAddress())
                    return;

                // Ustawiamy punkt lokalizacji
                try {
                    $geolocation = new Geolocation(
                        $event->getForm()->getConfig()->getOption('google_maps_api_key'),
                        'pl',
                        'pl'
                    );
                    $coordinates = $geolocation->getCoordinatesByString($party->getAddress());
                    $party->setPoint($coordinates);
                } catch (\Exception $e) {
                    $form->get('address')->addError(new FormError('Podany adres nie istnieje'));
                }
            })
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(
            [
                'google_maps_api_key'
            ]
        );
    }
}