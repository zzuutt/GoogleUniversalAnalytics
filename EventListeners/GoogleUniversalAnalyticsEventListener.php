<?php
/*************************************************************************************/
/*                                                                                   */
/*     Copyright (c) zzuutt                                                          */
/*     email : zzuutt34@free.fr                                                      */ 
/*                                                                                   */
/*     This program is free software; you can redistribute it and/or modify          */
/*     it under the terms of the GNU General Public License as published by          */
/*     the Free Software Foundation; either version 3 of the                         */
/*     GNU General Public License : http://www.gnu.org/licenses/                     */
/*                                                                                   */
/*                                                                                   */
/*************************************************************************************/

namespace GoogleUniversalAnalytics\EventListeners;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Log\Tlog;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use GoogleUniversalAnalytics\Model\Config;
use Thelia\Core\Translation\Translator;

class GoogleUniversalAnalyticsEventListener implements EventSubscriberInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
        
    public function setGoogleUniversalAnalyticsView(FilterResponseEvent $event)
    {
      if ((new GoogleUniversalAnalytics())->getModuleModel()->getActivate()) {
        /**
        * @var \Thelia\Core\HttpFoundation\Request
        */
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        $readConfig = Config::read(GoogleUniversalAnalytics::JSON_CONFIG_PATH);

        /**
         * Only display a notice
         * WARNING: This must be a temporary solution before the hooks.
         */
        $response = $event->getResponse();

        /**
         * We only get the actual response, parse it with DOMDocument,
         * and add the required tag at the beginning
         */
        $content = $response->getContent();

        /**
         * Parse the actual response
         */
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
        libxml_clear_errors();

        /**
         * Get the "body" node
         */
        $body = $dom->getElementsByTagName("body");

        /**
         * Just check that the response has a body node
         */
         
        $ret = null;
        if($body->length > 0) {
            $real_body = $body->item(0);
            $pathFile =  __DIR__."/../js/";
            $analytics = $pathFile."GoogleAnalytics.js";
            if($readConfig['IDVALUE']=='2') $analytics = $pathFile."UniversalAnalytics.js";

            if (is_readable($analytics)) {
                $src_name = file_get_contents($analytics);
                if ($src_name !== null) {
                    $scriptAnalytics = $src_name;
                } else {
                    throw new \Exception(Translator::getInstance()->trans("Can't read file ").$analytics.". ".
                        Translator::getInstance()->trans("The file is corrupted."));
                }
            } elseif (!file_exists($path)) {
                throw new \Exception(Translator::getInstance()->trans("The file ").$analytics.
                                    Translator::getInstance()->trans(" doesn't exist. You have to create it in order to use this module. Please see module's configuration page."));
            } else {
                throw new \Exception(Translator::getInstance()->trans("Can't read file ").$analytics.". ".
                                    Translator::getInstance()->trans("Please change the rights on the file."));
    
            }

            $src_name  = '';
            $pathCnil = $pathFile."cnil.js";

            if (is_readable($pathCnil)) {
                $src_name = file_get_contents($pathCnil);
                if ($src_name !== null) {
                    $ret = "gaProperty = '".$readConfig['IDVALUE']."';".$src_name;
                } else {
                    throw new \Exception(Translator::getInstance()->trans("Can't read file ").$pathCnil.". ".
                        Translator::getInstance()->trans("The file is corrupted."));
                }
            } elseif (!file_exists($path)) {
                throw new \Exception(Translator::getInstance()->trans("The file ").$pathCnil.
                                    Translator::getInstance()->trans(" doesn't exist. You have to create it in order to use this module. Please see module's configuration page."));
            } else {
                throw new \Exception(Translator::getInstance()->trans("Can't read file ").$pathCnil.". ".
                                    Translator::getInstance()->trans("Please change the rights on the file."));
    
            }
            $wrapper_tag = 'script';
            if($scriptAnalytics !== null)  $ret .= $scriptAnalytics;
            /**
             * Then create a Document element with the variables define
             * up there.
             */
            $element = new \DOMElement($wrapper_tag, $ret);

            /**
             * Insert the element to make it writable
             */
            /** @var \DOMElement $inserted_element */
            $inserted_element = $real_body->appendChild(
                $element
            );

            /**
             * Then add the attribute "src"
             */
            $inserted_element->setAttribute("type", "text/javascript");

            /**
             * Generate a string and set the new content into the response
             */
            if (!preg_match("#^(/admin)#i", $path)) {
                // $dom->substituteEntities = false;
                $content = $dom->saveHTML();
            }
            $response->setContent(str_replace('<?xml encoding="utf-8" ?>', '', $content));
        }

      }

    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => ['setGoogleUniversalAnalyticsView', 128]
        );
    }

}
