<?php
// modules/miprimermodulo/src/Controller/DemoController.php
namespace Webimpacto\MiPrimerModulo\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class DemoController extends FrameworkBundleAdminController
{
    public function demoAction()
    {
        $createProduct = $this->get('webimpacto.mi_primer_modulo.create_product');

        return $this->render('@Modules/miprimermodulo/templates/admin/demo.html.twig', [
            'customMessage' => $createProduct->getTranslatedCustomMessage(),
        ]);
    }
}