<?php
/**
 * 2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Andres Nacimiento <andresnacimiento@gmail.com>
 *  @copyright 2020 Andres Nacimiento
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Model
{

    public function installZone($zone)
    {
        Db::getInstance()->insert('zone', array(
            'id_zone' => (int)'',
            'name' => pSQL($zone),
            'active' => (int)'1',
        ));
    }

    public function installZoneShop($id_zone)
    {
        Db::getInstance()->insert('zone_shop', array(
            'id_zone' => (int)$id_zone,
            'id_shop' => (int)'1',
        ));
    }

    /* GETS ID Zone (ps_zone): id_zone */
    public function getIDZone($zone)
    {
        $sql = '
            SELECT `id_zone`
            FROM `' . _DB_PREFIX_ . 'zone`
            WHERE `name`="' . pSQL($zone) . '"
            ORDER BY `id_zone` DESC LIMIT 1
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        #return $value[0]["id_zone"];
        return $value[0]["id_zone"];
    }

    /* UPDATE ID Zone in ps_country */
    public function updateCountryIDZone($id_country, $id_zone)
    {
        $result = Db::getInstance()->update('country', array(
            'id_country' => (int)$id_country,
            'id_zone' => (int)$id_zone,
        ), 'id_country = ' . $id_country, 1, true);

        return $result;
    }

    /* UPDATE ID Zone in ps_state */
    public function updateStateIDZone($id_state, $id_zone)
    {
        $result = Db::getInstance()->update('state', array(
            'id_state' => (int)$id_state,
            'id_zone' => (int)$id_zone,
        ), 'id_state = ' . $id_state, 1, true);

        return $result;
    }

    /* INSERT a new Carrier in ps_carrier */
    public function insertCarrier($name)
    {
        Db::getInstance()->insert('carrier', array(
            'id_carrier' => (int)'',
            'id_reference' => (int)'1',
            'id_tax_rules_group' => (int)'0',
            'name' => pSQL($name),
            'url' => pSQL('https://www.correos.es/es/es/herramientas/localizador/envios/detalle?tracking-number=@'),
            'active' => (int)'0',
            'deleted' => (int)'0',
            'shipping_handling' => (int)'0',
            'range_behavior' => (int)'0',
            'is_module' => (int)'0',
            'is_free' => (int)'0',
            'shipping_external' => (int)'0',
            'need_range' => (int)'0',
            'external_module_name' => pSQL(''),
            'shipping_method' => (int)'1',
            'position' => (int)'0',
            'max_width' => (int)'0',
            'max_height' => (int)'0',
            'max_depth' => (int)'0',
            'max_weight' => (int)'0.000000',
            'grade' => (int)'0',
        ));

        return true;
    }

    /* GET ID Carrier from ps_carrier by name */
    public function getIDCarrier($name)
    {
        $sql = '
            SELECT `id_carrier`
            FROM `' . _DB_PREFIX_ . 'carrier`
            WHERE `name`="' . pSQL($name) . '"
            ORDER BY `id_carrier` DESC LIMIT 1
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_carrier"];
        #return $value;
    }

    /* INSERT a user group for a carrier */
    public function insertCarrierGroup($id_carrier, $id_group)
    {
        Db::getInstance()->insert('carrier_group', array(
            'id_carrier'    => (int)$id_carrier,
            'id_group'      => (int)$id_group,
        ));

        return true;
    }

    /* INSERT carrier delay for a carrier */
    public function insertCarrierLang($id_carrier, $delay)
    {
        Db::getInstance()->insert('carrier_lang', array(
            'id_carrier'	=> (int)$id_carrier,
            'id_shop'		=> (int)'1',
            'id_lang'		=> (int)'1',
            'delay'			=> pSQL($delay),
        ));

        return true;
    }

    /* INSERT carrier shop id for a carrier */
    public function insertCarrierShop($id_carrier)
    {
        Db::getInstance()->insert('carrier_shop', array(
            'id_carrier'	=> (int)$id_carrier,
            'id_shop'		=> (int)'1',
        ));

        return true;
    }

    /* INSERT carrier tax rules for a carrier */
    public function insertCarrierTaxRules($id_carrier)
    {
        Db::getInstance()->insert('carrier_tax_rules_group_shop', array(
            'id_carrier'	        => (int)$id_carrier,
            'id_tax_rules_group'   => (int)'1',
            'id_shop'		        => (int)'1',
        ));

        return true;
    }

    /* INSERT carrier zone for a carrier */
    public function insertCarrierZone($id_carrier, $id_zone)
    {
        Db::getInstance()->insert('carrier_zone', array(
            'id_carrier'	=> (int)$id_carrier,
            'id_zone'      => (int)$id_zone,
        ));

        return true;
    }

    /* INSERT carrier range weight for a carrier */
    public function insertCarrierRangeWeight($id_carrier, $start, $end)
    {
        Db::getInstance()->insert('range_weight', array(
            'id_range_weight'	=> (int)'',
            'id_carrier'		=> (int)$id_carrier,
            'delimiter1'		=> $start,
            'delimiter2'		=> $end,
        ));

        return true;
    }

    /* GET id_range_weight from ps_range_weight table */
    public function getIDCarrierRangeWeight($id_carrier, $start, $end)
    {
        $sql = '
            SELECT `id_range_weight`
            FROM `' . _DB_PREFIX_ . 'range_weight`
            WHERE `id_carrier`="' . pSQL($id_carrier) . '"
            AND `delimiter1`="' . pSQL($start) . '"
            AND `delimiter2`="' . pSQL($end) . '" 
            ORDER BY `id_carrier` DESC LIMIT 1
        ';
        $value = Db::getInstance()->ExecuteS($sql);

        return $value[0]["id_range_weight"];

    }

    /* Check if range weight exists */
    public function checkRangeWeight($id_carrier, $start, $end)
    {
        $sql = '
            SELECT `id_range_weight`
            FROM `' . _DB_PREFIX_ . 'range_weight`
            WHERE `id_carrier`="' . pSQL($id_carrier) . '" 
            AND `delimiter1`="' . pSQL($start) . '"
            AND `delimiter2`="' . pSQL($end) . '" 
            ORDER BY `id_carrier` DESC LIMIT 1
        ';

        $value = Db::getInstance()->ExecuteS($sql);

        if ($value == NULL) {
            return NULL;
        } else {
            return $value[0]["id_range_weight"];
        }

    }

    /* INSERT carrier price for a carrier weight range */
    public function insertCarrierRangePrice($id_carrier, $id_zone, $id_range_weight, $price)
    {
        Db::getInstance()->insert('delivery', array(
            'id_delivery'		=> (int)'',
            'id_shop'			=> NULL,
            'id_shop_group'		=> NULL,
            'id_carrier'		=> (int)$id_carrier,
            'id_range_price'	=> NULL,
            'id_range_weight'	=> (int)$id_range_weight,
            'id_zone'			=> (int)$id_zone,
            'price'				=> $price,
        ), true);

        return true;
    }

}
