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

namespace GoogleUniversalAnalytics;
use GoogleUniversalAnalytics\Model\Config;
use Thelia\Module\BaseModule;
use Thelia\Core\Translation\Translator;

class GoogleUniversalAnalytics extends BaseModule
{
    const JSON_CONFIG_PATH = "/Config/config.json";

    public function getCode()
    {
        return 'GoogleUniversalAnalytics';
    }
}
