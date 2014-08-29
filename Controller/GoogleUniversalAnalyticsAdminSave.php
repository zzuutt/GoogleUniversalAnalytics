<?php

namespace GoogleUniversalAnalytics\Controller;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Thelia\Controller\Admin\BaseAdminController;
use GoogleUniversalAnalytics\Model\Config;
use GoogleUniversalAnalytics\Form\ConfigureFormulaire;
use Thelia\Tools\URL;
use Symfony\Component\Routing\Router;
 
class GoogleUniversalAnalyticsAdminSave extends BaseAdminController
{
  function save()
    {
    		$error_message="";
            $conf = new Config();
            $form = new ConfigureFormulaire($this->getRequest());
            $vform = $this->validateForm($form);
    		$conf->setGOOGLEUNIVERSALANALYTICSTYPEVALUE($vform->get('TypeValue')->getData())
        ->setGOOGLEUNIVERSALANALYTICSIDVALUE($vform->get('IdValue')->getData())
                    ->write(GoogleUniversalAnalytics::JSON_CONFIG_PATH);
        $this->redirectToRoute("admin.module.configure",array(),
        array ( 'module_code'=>"GoogleUniversalAnalytics",
        '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction'));
    }
    
}
