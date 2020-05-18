<?php
// modules/miprimermodulo/src/Controller/DemoController.php
namespace mitienda\miprimermodulo\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class DemoController extends FrameworkBundleAdminController
{
    public function demoAction()
    {
        $yourService = $this->get('mitienda.miprimermodulo.src.createProduct');

        return $this->render('@Modules/yourmodule/templates/admin/demo.html.twig', [
            'customMessage' => $yourService->getTranslatedCustomMessage(),
        ]);
    }
}