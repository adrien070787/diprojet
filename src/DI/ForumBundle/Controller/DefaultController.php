<?php

namespace DI\ForumBundle\Controller;

use DI\ForumBundle\Entity\Subject;
use DI\ForumBundle\Form\SubjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listesubjects = $em->getRepository('DIForumBundle:Subject')->findAll();

        return $this->render('DIForumBundle:Default:index.html.twig',
            array('listesubjects' => $listesubjects));
    }

    public function addsubjectAction(Request $request) {
        $subject = new Subject();
        $form = $this->get('form.factory')->create(SubjectType::class, $subject);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($subject);
                $em->flush();

                $this->addFlash('success', 'Sujet créé avec succès');

                return $this->redirectToRoute('di_forum_homepage');
            }
        }

        return $this->render('DIForumBundle:Default:add.html.twig',
            array('formulaire' => $form->createView()));

    }
}
