<?php
/*************************************************************************************/
/*                                                                                   */
/*                                                                                   */
/*      email : zzuutt34@free.fr                                                     */
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
