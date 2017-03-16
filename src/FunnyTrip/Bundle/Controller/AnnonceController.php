<?php

namespace FunnyTrip\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use FunnyTrip\Bundle\Entity\Annonce;
use FunnyTrip\Bundle\Entity\Reservation;



/**
 * Annonce controller.
 *
 * @Route("/annonce")
 */
class AnnonceController extends Controller
{
  /**
   * Lists all Annonce entities.
   *
   * @Route("/", name="annonce")
   * @Method("GET")
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $queryBuilder = $em->getRepository('FunnyTripBundle:Annonce')->createQueryBuilder('e');

    list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
    list($annonces, $pagerHtml) = $this->paginator($queryBuilder, $request);

    return $this->render('annonce/index.html.twig', array(
      'annonces' => $annonces,
      'pagerHtml' => $pagerHtml,
      'filterForm' => $filterForm->createView(),

    ));
  }


  /**
   * Create filter form and process filter request.
   *
   */
  protected function filter($queryBuilder, Request $request)
  {
    $session = $request->getSession();
    $filterForm = $this->createForm('FunnyTrip\Bundle\Form\AnnonceFilterType');

    // Reset filter
    if ($request->get('filter_action') == 'reset') {
      $session->remove('AnnonceControllerFilter');
    }

    // Filter action
    if ($request->get('filter_action') == 'filter') {
      // Bind values from the request
      $filterForm->handleRequest($request);

      if ($filterForm->isValid()) {
        // Build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
        // Save filter to session
        $filterData = $filterForm->getData();
        $session->set('AnnonceControllerFilter', $filterData);
      }
    } else {
      // Get filter from session
      if ($session->has('AnnonceControllerFilter')) {
        $filterData = $session->get('AnnonceControllerFilter');

        foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
          if (is_object($filter)) {
            $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
          }
        }

        $filterForm = $this->createForm('FunnyTrip\Bundle\Form\AnnonceFilterType', $filterData);
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
      }
    }

    return array($filterForm, $queryBuilder);
  }


  /**
   * Get results from paginator and get paginator view.
   *
   */
  protected function paginator($queryBuilder, Request $request)
  {
    //sorting
    $sortCol = $queryBuilder->getRootAlias() . '.' . $request->get('pcg_sort_col', 'id');
    $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
    // Paginator
    $adapter = new DoctrineORMAdapter($queryBuilder);
    $pagerfanta = new Pagerfanta($adapter);
    $pagerfanta->setMaxPerPage($request->get('pcg_show', 10));

    try {
      $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
    } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
      $pagerfanta->setCurrentPage(1);
    }

    $entities = $pagerfanta->getCurrentPageResults();

    // Paginator - route generator
    $me = $this;
    $routeGenerator = function ($page) use ($me, $request) {
      $requestParams = $request->query->all();
      $requestParams['pcg_page'] = $page;
      return $me->generateUrl('annonce', $requestParams);
    };

    // Paginator - view
    $view = new TwitterBootstrap3View();
    $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
      'proximity' => 3,
      'prev_message' => 'previous',
      'next_message' => 'next',
    ));

    return array($entities, $pagerHtml);
  }


  /**
   * Displays a form to create a new Annonce entity.
   *
   * @Route("/new", name="annonce_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {

    $annonce = new Annonce();

    //Attribution de l'id du conduction
    $annonce->setUser($this->getUser());

    $form = $this->createForm('FunnyTrip\Bundle\Form\AnnonceType', $annonce);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($annonce);
      $em->flush();

      $editLink = $this->generateUrl('annonce_edit', array('id' => $annonce->getId()));
      $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Annonce créée</a>");

      $nextAction = $request->get('submit') == 'save' ? 'annonce' : 'annonce_new';
      return $this->redirectToRoute($nextAction);
    }
    return $this->render('annonce/new.html.twig', array(
      'annonce' => $annonce,
      'form' => $form->createView(),
    ));
  }


  /**
   * Finds and displays a Annonce entity.
   *
   * @Route("/{id}", name="annonce_show")
   * @Method("GET")
   */
  public function showAction(Annonce $annonce)
  {


    $deleteForm = $this->createDeleteForm($annonce);
    return $this->render('annonce/show.html.twig', array(
      'annonce' => $annonce,
      'delete_form' => $deleteForm->createView(),
    ));
  }


  /**
   * Displays a form to edit an existing Annonce entity.
   *
   * @Route("/{id}/edit", name="annonce_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Annonce $annonce)
  {
    $deleteForm = $this->createDeleteForm($annonce);
    $editForm = $this->createForm('FunnyTrip\Bundle\Form\AnnonceType', $annonce);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($annonce);
      $em->flush();

      $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
      return $this->redirectToRoute('annonce_edit', array('id' => $annonce->getId()));
    }
    return $this->render('annonce/edit.html.twig', array(
      'annonce' => $annonce,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }


  /**
   * Deletes a Annonce entity.
   *
   * @Route("/{id}", name="annonce_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Annonce $annonce)
  {

    $form = $this->createDeleteForm($annonce);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($annonce);
      $em->flush();
      $this->get('session')->getFlashBag()->add('success', 'The Annonce was deleted successfully');
    } else {
      $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Annonce');
    }

    return $this->redirectToRoute('annonce');
  }

  /**
   * Creates a form to delete a Annonce entity.
   *
   * @param Annonce $annonce The Annonce entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Annonce $annonce)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('annonce_delete', array('id' => $annonce->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }

  /**
   * Delete Annonce by id
   *
   * @Route("/delete/{id}", name="annonce_by_id_delete")
   * @Method("GET")
   */
  public function deleteByIdAction(Annonce $annonce)
  {
    $em = $this->getDoctrine()->getManager();

    try {
      $em->remove($annonce);
      $em->flush();
      $this->get('session')->getFlashBag()->add('success', 'The Annonce was deleted successfully');
    } catch (Exception $ex) {
      $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Annonce');
    }

    return $this->redirect($this->generateUrl('annonce'));

  }


  /**
   * Bulk Action
   * @Route("/bulk-action/", name="annonce_bulk_action")
   * @Method("POST")
   */
  public function bulkAction(Request $request)
  {
    $ids = $request->get("ids", array());
    $action = $request->get("bulk_action", "delete");

    if ($action == "delete") {
      try {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FunnyTripBundle:Annonce');

        foreach ($ids as $id) {
          $annonce = $repository->find($id);
          $em->remove($annonce);
          $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'annonces was deleted successfully!');

      } catch (Exception $ex) {
        $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the annonces ');
      }
    }

    return $this->redirect($this->generateUrl('annonce'));
  }


}
