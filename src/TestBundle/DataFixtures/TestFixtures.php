<?php
namespace TestBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use TestBundle\Entity\Party;
use Juskiewicz\Geolocation\Geolocation;
use Symfony\Component\DependencyInjection\{
    ContainerAwareInterface,
    ContainerInterface
};

class TestFixtures extends Fixture implements ContainerAwareInterface
{
    // Przykładowe dane pola name
    private const POST_NAME = [
        'Koncert zespołu Bajm',
        'Kurs programowania Symfony 3',
        'Nocny maraton filmowy',
        'Need for speed',
        'Gotowanie z Okrasą',
        'Rozdajemy milion jabłek!',
        'Big run - 10km dla Adasia',
    ];

    // Przykładowe dane pola description
    private const POST_DESCRIPTION = [
        'Jakiś fajny opis 1',
        'Będzie to super wydarzenie',
        'Czekamy na Ciebie i Twoich znajomych!',
        'Na to wydarzenie czekaliśmy od dawna!',
    ];

    // Przykładowe dane pola address
    private const POST_ADDRESS = [
        'Marszałkowska 31, Warszawa',
        'os. Tysiąclecia 71, Poznań',
        'Marszewska 10, Pleszew',
        'Baraniaka 2, Poznań',
        'Towarowa 22, Warszawa',
        'Parkowa 7, Lenartowice',
    ];

    // Przykładowe dane pola email
    private const POST_EMAIL = [
        'tomasz@domena.pl',
        'biuro@grafiko.pl',
        'biuro@autentika.pl',
        'kamil.borkowski@wp.pl',
        'to.juskiewicz@gmail.com',
    ];

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null) : void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) : void
    {
        $this->loadEvents($manager);
    }

    /**
     * {@inheritdoc}
     */
    private function loadEvents(ObjectManager $manager) : void
    {
        // Tworzy przykładowe losowe obiekty
        for ($i = 0; $i < 20; $i++) {
            $party = new Party();
            $party->setName(self::POST_NAME[rand(0, count(self::POST_NAME) - 1)]);
            $party->setDescription(self::POST_DESCRIPTION[rand(0, count(self::POST_DESCRIPTION) - 1)]);
            $party->setAddress(self::POST_ADDRESS[rand(0, count(self::POST_ADDRESS) - 1)]);
            $party->setEmail(self::POST_EMAIL[rand(0, count(self::POST_EMAIL) - 1)]);
            $fromAt = new \DateTime();
            $fromAt->modify('+' . rand(7, 10) . ' day');
            $party->setFromAt($fromAt);
            $toAt = new \DateTime();
            $toAt->modify('+' . rand(11, 20) . ' day');
            $party->setToAt($toAt);

            // Pobieramy i ustawiamy lokalizacje wydarzenia
            $geolocation = new Geolocation(
                $this->container->getParameter('google_maps_api_key'),
                'pl',
                'pl'
            );
            $coordinates = $geolocation->getCoordinatesByString($party->getAddress());
            $party->setPoint($coordinates);

            $manager->persist($party);
        }

        $manager->flush();
    }
}