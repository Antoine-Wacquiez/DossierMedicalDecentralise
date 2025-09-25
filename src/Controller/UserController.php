<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $currentUser = $this->getUser();

        // 🔒 Interdit aux admins
        if ($this->isGranted('ROLE_ADMIN') && $user !== $currentUser) {
            throw $this->createAccessDeniedException("⛔ Vous ne pouvez modifier que vos propres informations.");
        }

        // 🔒 Un patient peut modifier seulement son propre compte
        if ($this->isGranted('ROLE_PATIENT') && $user !== $currentUser) {
            throw $this->createAccessDeniedException("⛔ Vous ne pouvez modifier que vos propres informations.");
        }

        // 🔒 Un médecin peut modifier seulement son propre compte
        if ($this->isGranted('ROLE_MEDECIN') && $user !== $currentUser) {
            throw $this->createAccessDeniedException("⛔ Vous ne pouvez modifier que vos propres informations.");
        }

        // ✅ Création du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', '✅ Informations mises à jour.');

            // Redirection différente selon le rôle
            if ($this->isGranted('ROLE_PATIENT')) {
                return $this->redirectToRoute('app_patient_dashboard');
            } elseif ($this->isGranted('ROLE_MEDECIN')) {
                return $this->redirectToRoute('app_medecin_dashboard');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
