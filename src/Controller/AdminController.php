<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // ✅ celui-ci est inclus de base

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        $medecins = array_filter($users, fn(User $u) => in_array('ROLE_MEDECIN', $u->getRoles()));
        $patients = array_filter($users, fn(User $u) => in_array('ROLE_PATIENT', $u->getRoles()));
        $simples  = array_filter(
            $users,
            fn(User $u) =>
            !in_array('ROLE_MEDECIN', $u->getRoles()) &&
                !in_array('ROLE_PATIENT', $u->getRoles()) &&
                !in_array('ROLE_ADMIN', $u->getRoles())
        );

        return $this->render('admin/dashboard.html.twig', [
            'medecins' => $medecins,
            'patients' => $patients,
            'users'    => $simples,
        ]);
    }

    #[Route('/admin/user/{id}/role/{role}', name: 'app_admin_set_role')]
    public function setRole(User $user, string $role, EntityManagerInterface $em): RedirectResponse
    {
        // sécurité : empêcher d’ajouter un rôle bidon
        $validRoles = ['ROLE_PATIENT', 'ROLE_MEDECIN', 'ROLE_ADMIN'];
        if (!in_array($role, $validRoles, true)) {
            $this->addFlash('danger', 'Rôle invalide');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $user->setRoles([$role, 'ROLE_USER']); // on ajoute toujours ROLE_USER
        $em->flush();

        $this->addFlash('success', sprintf('Rôle %s attribué à %s', $role, $user->getUsername()));
        return $this->redirectToRoute('app_admin_dashboard');
    }

    #[Route('/admin/user/{id}/delete', name: 'app_admin_delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', sprintf('Utilisateur %s supprimé avec succès', $user->getUsername()));
        return $this->redirectToRoute('app_admin_dashboard');
    }
}
