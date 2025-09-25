<?php

namespace App\Twig;

use App\Service\AdminProvider;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AdminExtension extends AbstractExtension implements GlobalsInterface
{
    private AdminProvider $adminProvider;

    public function __construct(AdminProvider $adminProvider)
    {
        $this->adminProvider = $adminProvider;
    }

    public function getGlobals(): array
    {
        return [
            'admin_contact' => $this->adminProvider->get(),
        ];
    }
}
