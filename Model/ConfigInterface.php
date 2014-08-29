<?php
namespace GoogleUniversalAnalytics\Model;

interface ConfigInterface
{
    // Data access
    public function write($file=null);
    public static function read($file=null);

    // variables setters

    /*
     * @return GoogleUniversalAnalytics\Model\ConfigInterface
     */
    public function setGOOGLEUNIVERSALANALYTICSTYPEVALUE($TYPEVALUE);
    public function setGOOGLEUNIVERSALANALYTICSIDVALUE($IDVALUE);

}
