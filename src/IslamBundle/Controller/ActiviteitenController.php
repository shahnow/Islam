<?php

namespace IslamBundle\Controller;

use IslamBundle\Entity\Activiteiten;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Activiteiten controller.
 *
 * @Route("/activiteiten")
 */
class ActiviteitenController extends Controller
{
    /**
     * Lists all activiteiten entities.
     *
     * @Route("/", name="activiteiten_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $activiteitens = $em->getRepository('IslamBundle:Activiteiten')->findAll();

        return $this->render('@Islam/activiteiten/index.html.twig', array(
            'activiteitens' => $activiteitens,
        ));
    }

    /**
     * Creates a new activiteiten entity.
     *
     * @Route("/new", name="activiteiten_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $activiteiten = new Activiteiten();
        $form = $this->createForm('IslamBundle\Form\ActiviteitenType', $activiteiten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activiteiten);
            $em->flush();

            return $this->redirectToRoute('activiteiten_show', array('id' => $activiteiten->getId()));
        }

        return $this->render('@Islam/activiteiten/new.html.twig', array(
            'activiteiten' => $activiteiten,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a activiteiten entity.
     *
     * @Route("/{id}", name="activiteiten_show")
     * @Method("GET")
     */
    public function showAction(Activiteiten $activiteiten)
    {
        $deleteForm = $this->createDeleteForm($activiteiten);

        return $this->render('@Islam/activiteiten/show.html.twig', array(
            'activiteiten' => $activiteiten,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activiteiten entity.
     *
     * @Route("/{id}/edit", name="activiteiten_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Activiteiten $activiteiten)
    {
        $deleteForm = $this->createDeleteForm($activiteiten);
        $editForm = $this->createForm('IslamBundle\Form\ActiviteitenType', $activiteiten);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activiteiten_edit', array('id' => $activiteiten->getId()));
        }

        return $this->render('@Islam/activiteiten/edit.html.twig', array(
            'activiteiten' => $activiteiten,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a activiteiten entity.
     *
     * @Route("/{id}", name="activiteiten_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Activiteiten $activiteiten)
    {
        $form = $this->createDeleteForm($activiteiten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activiteiten);
            $em->flush();
        }

        return $this->redirectToRoute('activiteiten_index');
    }

    /**
     * Creates a form to delete a activiteiten entity.
     *
     * @param Activiteiten $activiteiten The activiteiten entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Activiteiten $activiteiten)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activiteiten_delete', array('id' => $activiteiten->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
