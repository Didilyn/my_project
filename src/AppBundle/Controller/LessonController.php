<?php
/**
 * Created by PhpStorm.
 * User: Didilyn
 * Date: 18/11/15
 * Time: 11:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Form\LessonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LessonController extends Controller
{
    /**
     * @Route("/lesson", name="lesson")
     */
    public function indexAction (){
        // 1. Doctrine
        $em = $this->getDoctrine()->getManager();
        // 2. Repository (LessonRepository)
        $repo = $em->getRepository('AppBundle:Lesson');
        // 3. findAll()
        $lessons = $repo->findAll();

        return $this->render('lesson/lessons.html.twig', [
            'lessons'=> $lessons,
        ]);
    }

    /**
     * @Route("/lesson/create", name="lesson_create")
     */
    public function createAction(Request $request)
    {
        $lesson = new Lesson();
        $form = $this->createForm(new LessonType(), $lesson);

        $form->add('submit','submit', [
            'label'=> 'create',
        ]);
        $form->handleRequest($request);

        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lesson');
        }

        $user = $this->getUser();

        return $this->render('lesson/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lesson/{id}/edit",name="lesson_edit")
     */
    public function updateAction(Request $request, $id)
    {
        $lesson = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lesson')->find($id);

        if (null === $lesson)
            throw $this->createNotFoundException(sprintf(
                'Lesson n%d found.',
                $id
            ));

        $form = $this->createForm(new LessonType(), $lesson);
        $form->add('submit','submit', [
            'label'=> 'update',
        ]);
        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/lesson/{id}/delete",name="lesson_delete")
     */
    public function DeleteAction(Request $request, $id)
    {
        $lesson = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lesson')->find($id);

        if (null === $lesson)
            throw $this->createNotFoundException(sprintf(
                'Lesson n%d found.',
                $id
            ));

        $form = $this->createForm(new LessonType(), $lesson);
        $form->add('submit','submit', [
            'label'=> 'delete',
        ]);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em->remove($lesson);
            $em->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}