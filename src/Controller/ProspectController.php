<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Search\SearchProspect;
use App\Form\ProspectAffectType;
use App\Form\SearchProspectType;
use App\Form\ProspectRelanceType;
use App\Repository\ProspectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/prospect")
 * @IsGranted("ROLE_USER", message="Tu ne peut pas acces a cet ressource")
 * 
 */

class ProspectController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {

        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="app_prospect_index", methods={"GET", "POST"}) 
     */
    public function index(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response
    {

        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);


        $form = $this->createForm(SearchProspectType::class, $data);
        // $form->handleRequest($request);
        $form->handleRequest($this->requestStack->getCurrentRequest());

        // Pour avoir tous les prospect en taut que je suis admin 
        $user = $security->getUser();
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {

            // je recupere les prospects qui son pas encors affecter 

            $prospect =  $prospectRepository->findAllSearch($data, null);

            // recupere seulement les pas encour affect et cree ce jour
            $prospectpas = $prospectRepository->findByUserPaAffecter($data, null);
            // recupere qui sont relance 
            $prospectrlc = $prospectRepository->findRelanced($data,  null);
            $this->requestStack->getSession()->set('security', count($prospectpas));
            return $this->render('prospect/index.html.twig', [
                'prospects' => $prospect,
                'prospectpas' => $prospectpas,
                'prospectrlc' => $prospectrlc,
                'search_form' => $form->createView()
            ]);
        } else if (in_array('ROLE_TEAM', $user->getRoles(), true)) {

            // je recupe seulement les prospects affecter au mon equipe
            $prospect = $prospectRepository->findAllChefSearch($data, $user, null);
            $prospectChef = $prospectRepository->findByUserChefEquipe($data, $user, null);
            $prospectRelance = $prospectRepository->findByRelanceChefEquipe($data, $user, null);

            return $this->render('prospect/indexchef.html.twig', [
                'prospects' => $prospect,
                'prospectRelance' => $prospectRelance,
                'prospectChef' => $prospectChef,
                'search_form' => $form->createView()
            ]);
        }


        // Alors si je suis pas admin  je recupere selement les prospect attacher a moi 
        else {
            $prospectpas = $prospectRepository->findByUserAffecterCmrcl($data, $user, null);
            $prospect =  $prospectRepository->findByUserConect($data, $user);
            // $request->getSession()->set('security', count($prospect) );
        }

        $this->requestStack->getSession()->set('security', count($prospect));


        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'prospectpas' => $prospectpas,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/allprospc", name="allprosp_index", methods={"GET", "POST"}) 
     */
    public function allprosp(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response

    {
        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);
        $form = $this->createForm(SearchProspectType::class, $data);
        $form->handleRequest($this->requestStack->getCurrentRequest());
        $user = $security->getUser();
        $prospect =  $prospectRepository->findAllSearch($data, $user, null);
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newprospect", name="newprospect_index", methods={"GET", "POST"}) 
     */
    public function newprospect(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response

    {
        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);
        $form = $this->createForm(SearchProspectType::class, $data);
        $form->handleRequest($this->requestStack->getCurrentRequest());
        $user = $security->getUser();
        $prospect =  $prospectRepository->findByUserPaAffecter($data, null);
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/relance", name="relancejour_index", methods={"GET", "POST"}) 
     */
    public function relancejour(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response

    {
        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);
        $form = $this->createForm(SearchProspectType::class, $data);
        $form->handleRequest($this->requestStack->getCurrentRequest());
        $prospect =  $prospectRepository->findRelanced($data, null);
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/relancenontraite", name="relancenontraite_index", methods={"GET", "POST"}) 
     */
    public function relancenontraite(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response

    {
        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);
    }

    /**
     * @Route("/unjoinable", name="unjoinable_index", methods={"GET", "POST"}) 
     */
    public function unjoinable(Request $request,  ProspectRepository $prospectRepository,  Security $security): Response

    {
        $data = new SearchProspect();
        $data->page = $request->query->get('page', 1);
    }

    /**
     * @Route("/new", name="app_prospect_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProspectRepository $prospectRepository): Response
    {
        $prospect = new Prospect();
        $form = $this->createForm(ProspectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prospect->setAutor($this->getUser());
            $prospectRepository->add($prospect, true);

            $this->addFlash('success', 'Votre Prospect a été ajouté avec succès!');
            return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('prospect/new.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_prospect_show", methods={"GET"})
     */
    public function show(Prospect $prospect): Response
    {
        return $this->render('prospect/show.html.twig', [
            'prospect' => $prospect,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_prospect_edit", methods={"GET", "POST"}) 
     */
    public function edit(Request $request, Prospect $prospect, ProspectRepository $prospectRepository): Response
    {
        $form = $this->createForm(ProspectAffectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prospectRepository->add($prospect, true);

            $this->addFlash('info', 'Votre Prospect a été affecté avec succès!');
            return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partials/_show_modal.html.twig', [
            'prospect' => $prospect,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/relance", name="app_prospect_relance", methods={"GET", "POST"}) 
     */
    public function relance(Request $request, Prospect $prospect, ProspectRepository $prospectRepository): Response
    {
        $formR = $this->createForm(ProspectRelanceType::class, $prospect);
        $formR->handleRequest($request);

        if ($formR->isSubmitted() && $formR->isValid()) {
            $prospectRepository->add($prospect, true);

            $this->addFlash('info', 'Votre Prospect a été relancer avec succès!');
            return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partials/_show_relance.html.twig', [
            'prospect' => $prospect,
            'form' => $formR,
        ]);
    }


    /**
     * @Route("/{id}", name="app_prospect_delete", methods={"POST"})
     */
    public function delete(Request $request, Prospect $prospect, ProspectRepository $prospectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prospect->getId(), $request->request->get('_token'))) {
            $prospectRepository->remove($prospect, true);
        }

        return $this->redirectToRoute('app_prospect_index', [], Response::HTTP_SEE_OTHER);
    }
}
