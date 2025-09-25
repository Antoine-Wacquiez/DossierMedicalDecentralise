<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // ✅ celui-ci est inclus de base
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;

#[IsGranted('ROLE_PATIENT')]
final class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser(); // récupère l'utilisateur connecté

        return $this->render('patient/dashboard.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/patient/{id}/dossier/pdf', name: 'app_patient_dossier_pdf')]
    public function dossierPdf(User $user): Response
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->renderView('patient/dossier_pdf.html.twig', [
            'user' => $user,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // ⚠️ Ici on sort direct le flux PDF
        $dompdf->stream('dossier-medical-' . $user->getNom() . '.pdf', [
            "Attachment" => false, // false = ouvrir dans le navigateur
        ]);

        // ✅ IMPORTANT : on stoppe Symfony pour éviter qu'il renvoie du HTML en plus
        exit;
    }
}
