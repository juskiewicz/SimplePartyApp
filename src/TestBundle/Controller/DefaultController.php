<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TestBundle\Entity\Party;
use TestBundle\Form\{
    PartyType,
    SearchPartyType
};

class DefaultController extends Controller
{
    /**
     * @Route("/", name="test_index")
     */
    public function indexAction(Request $request)
    {
        /* @var \TestBundle\Repository\PartyRepository $partyRepository  */
        $partyRepository = $this->getDoctrine()->getRepository(Party::class);

        // Tworzymy formularz wyszukiwania
        $form = $this->createForm(SearchPartyType::class);
        $form->handleRequest($request);

        // Walidacje formularza
        if ($form->isSubmitted() && $form->isValid()) {
            $parties = $partyRepository->findAllByName($form['search']->getData());
        } else {
            $parties = $partyRepository->findAll();
        }

        return $this->render('TestBundle:Default:index.html.twig', [
            'parties' => $parties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="test_add")
     */
    public function addAction(Request $request)
    {
        $party = new Party();

        // Tworzymy formularz wyszukiwania
        $form = $this->createForm(
            PartyType::class,
            $party,
            [
                'google_maps_api_key' => $this->container->getParameter('google_maps_api_key')
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Zapisujemy impreze do bazy danych
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();

            // Dodajemy powiadomienie
            $this->addFlash('notice', 'Impreza została dodana.');

            // Przekierowanie do strony domowej
            return $this->redirectToRoute('test_index');
        }

        return $this->render('TestBundle:Default:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="test_show")
     */
    public function showAction(Party $party)
    {
        return $this->render('TestBundle:Default:show.html.twig', [
            'party' => $party
        ]);
    }
}
