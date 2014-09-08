<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.     */
/*                                                                                   */
/*************************************************************************************/

namespace GoogleUniversalAnalytics\Form;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\ExecutionContextInterface;
use Thelia\Model\ConfigQuery;
use Thelia\Model\CustomerQuery;
use Thelia\Form\BaseForm;
use Thelia\Core\Translation\Translator;

class ConfigureFormulaire extends BaseForm
{
    public function getName()
    {
        return "configuregoogleuniversalanalytics";
    }

    protected function buildForm()
    {
        $values = null;
        $path = __DIR__."/../".GoogleUniversalAnalytics::JSON_CONFIG_PATH;
        if (is_readable($path)) {
            $values = json_decode(file_get_contents($path),true);
        }
        $this->formBuilder

            ->add('TypeValue', 'text', array(
                'label' => Translator::getInstance()->trans('TypeValue'),
                'label_attr' => array(
                    'for' => 'TypeValue'
                ),
                'data' => (null === $values ?'':$values["TYPEVALUE"]),
                'constraints' => array(
                    new Constraints\NotBlank()
                )
            ))
            ->add('IdValue', 'text', array(
                'label' => Translator::getInstance()->trans('IdValue'),
                'label_attr' => array(
                    'for' => 'IdValue'
                ),
                'data' => (null === $values ?'':$values["IDVALUE"]),
                'constraints' => array(
                    new Constraints\NotBlank()
                )
            ))
            ->add('linkCGV', 'text', array(
                'label' => Translator::getInstance()->trans('linkCGV'),
                'label_attr' => array(
                    'for' => 'linkCGV'
                ),
                'data' => (null === $values ?'':$values["LINKCGV"]),
                'constraints' => array(
                    new Constraints\NotBlank()
                )
            ))
        ;
    }
}
