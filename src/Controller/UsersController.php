<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Form\EditeProfileType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users/utulisateur")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/profil", name="users_profil", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
           'users' => $usersRepository->findAll(),
        ]
    );
    }

    /**
     * @Route("/new", name="users_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/user", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/editprofile", name="profile_edit", methods={"GET", "POST"})
     */
    public function editprofile(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    { 
        $user = $this->getUser();
        $form = $this->createForm(EditeProfileType::class,$user);
        //$form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
         $this->addFlash(
            'message',
            'profile mis a jour'
         );;
            return $this->redirectToRoute('users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edituser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edituser", name="users_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_index', [], Response::HTTP_SEE_OTHER);
    }
}
