<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DossierMedical;
use App\Entity\Allergies;
use App\Entity\Traitements;
use App\Form\DossierMedicalType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

#[IsGranted('ROLE_MEDECIN')] // ✅ seul un médecin peut accéder à ce contrôleur
class MedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin_dashboard')]
    public function index(UserRepository $userRepository): Response
    {
        $patients = array_filter(
            $userRepository->findAll(),
            fn($u) => in_array('ROLE_PATIENT', $u->getRoles(), true)
        );

        return $this->render('medecin/dashboard.html.twig', [
            'patients' => $patients,
        ]);
    }

    #[Route('/medecin/patient/{id}', name: 'app_medecin_patient')]
    public function show(User $patient): Response
    {
        return $this->render('medecin/patient_show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/medecin/patient/{id}/dossier/new', name: 'app_medecin_dossier_new')]
    public function createDossier(User $patient, Request $request, EntityManagerInterface $em): Response
    {
        $dossier = new DossierMedical();
        $dossier->setDateCreation(new \DateTime());
        $dossier->setDateMaj(new \DateTime());

        $form = $this->createForm(DossierMedicalType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setDossierMedical($dossier);
            $em->persist($dossier);
            $em->flush();

            $this->addFlash('success', '✅ Dossier médical créé avec succès.');
            return $this->redirectToRoute('app_medecin_patient', ['id' => $patient->getId()]);
        }

        return $this->render('medecin/dossier_form.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
            'isNew' => true
        ]);
    }

    #[Route('/medecin/patient/{id}/dossier/edit', name: 'app_medecin_dossier_edit')]
    public function editDossier(User $patient, Request $request, EntityManagerInterface $em): Response
    {
        $dossier = $patient->getDossierMedical();

        if (!$dossier) {
            $this->addFlash('error', '⚠️ Ce patient n’a pas encore de dossier.');
            return $this->redirectToRoute('app_medecin_dashboard');
        }

        $form = $this->createForm(DossierMedicalType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setDateMaj(new \DateTime());
            $em->flush();

            $this->addFlash('success', '✅ Dossier médical mis à jour.');
            return $this->redirectToRoute('app_medecin_patient', ['id' => $patient->getId()]);
        }

        return $this->render('medecin/dossier_form.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
            'isNew' => false
        ]);
    }
}
