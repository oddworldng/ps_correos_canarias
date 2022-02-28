<?php
/**
* 2022 PrestaShop
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
*  @copyright 2022 Andres Nacimiento
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_Correos_Canarias extends Module
{
    /* CONSTRUCT */
    public function __construct()
    {
        $this->name = 'ps_correos_canarias';
        $this->displayName = $this->l('Correos desde Canarias');
        $this->description = $this->l('Configuracion de transportista de Correos para envios desde Canarias');
        $this->tab = 'shipping_logistics';
        $this->version = '1.0.0';
        $this->author = 'Andres Nacimiento';
        $this->bootstrap = true;
        $this->module_key = '';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        parent::__construct();

    }
    /* INSTALL */
    public function install()
    {
        return parent::install()
            /* Install Db */
            && $this->installDb();
    }
    /* UNINSTALL */
    public function uninstall()
    {
        return (
            parent::uninstall()
            && $this->uninstallDB()
            && Configuration::deleteByName('ps_correos_canarias')
        );
    }
    public function getContent()
    {
        return $this->display(__FILE__, 'views/templates/admin/template.tpl');
    }
    /* Insert values into DB */
    public function installDb()
    {
        include "classes/db.php";
        $db = new Model();

        include "classes/db_backup.php";
        $db_backup = new DBBackup();

        /* CREATE BACKUP */

        /* Table: ps_country */
        $db_backup->createTablePSCountryBackup();
        $db_backup->backupPSCountry();

        /* Table: ps_state */
        $db_backup->createTablePSStateBackup();
        $db_backup->backupPSState();

        /* INSTALL ZONES */
        /* Ubicaciones geograficas > Zonas */
        $zone_list = [
            "Zona 1:Misma provincia (misma isla)",
            "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "Zona 6: Envíos a Canarias interislas",
            "Zona 9: Envíos a Portugal peninsular con origen Canarias",
            "Zona EU1: Alemania, Austria,Bélgica...",
            "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "ZONA AM: Antigua y Barbuda, Argentina...",
            "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "ZONA AS-OC 2: Australia, Nueva Zelanda...",
            "ZONA AF: Angola, Benin, Botswana...",
        ];

        /*foreach ($zone_list as &$zone) {
            $db->installZone($zone);
            $id_zone = $db->getIDZone($zone);
            $db->installZoneShop($id_zone);
        }*/

        /* ASIGN ZONE TO COUNTRY */
        $zone_country_array = [
            "229" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "228" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "1" => "Zona EU1: Alemania, Austria,Bélgica...",
            "41" => "ZONA AF: Angola, Benin, Botswana...",
            "38" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "44" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "45" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "46" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "24" => "ZONA AS-OC 2: Australia, Nueva Zelanda...",
            "2" => "Zona EU1: Alemania, Austria,Bélgica...",
            "47" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "48" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "51" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "3" => "Zona EU1: Alemania, Austria,Bélgica...",
            "53" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "55" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "52" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "34" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "58" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "59" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "233" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "62" => "ZONA AF: Angola, Benin, Botswana...",
            "56" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "63" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "64" => "ZONA AF: Angola, Benin, Botswana...",
            "4" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "67" => "ZONA AF: Angola, Benin, Botswana...",
            "68" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "5" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "76" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "69" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "74" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "75" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "20" => "Zona EU1: Alemania, Austria,Bélgica...",
            "78" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "81" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "82" => "ZONA AF: Angola, Benin, Botswana...",
            "85" => "ZONA AF: Angola, Benin, Botswana...",
            "37" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "191" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "86" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "87" => "ZONA AF: Angola, Benin, Botswana...",
            "170" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "7" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "8" => "Zona EU1: Alemania, Austria,Bélgica...",
            "91" => "ZONA AF: Angola, Benin, Botswana...",
            "92" => "ZONA AF: Angola, Benin, Botswana...",
            "93" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "94" => "ZONA AF: Angola, Benin, Botswana...",
            "97" => "Zona EU1: Alemania, Austria,Bélgica...",
            "95" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "9" => "Zona EU1: Alemania, Austria,Bélgica...",
            "96" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "100" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "102" => "ZONA AF: Angola, Benin, Botswana...",
            "104" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "105" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "107" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "142" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "109" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "110" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "111" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "26" => "Zona EU1: Alemania, Austria,Bélgica...",
            "108" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "29" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "10" => "Zona EU1: Alemania, Austria,Bélgica...",
            "114" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "11" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "115" => "Zona EU1: Alemania, Austria,Bélgica...",
            "116" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "118" => "ZONA AF: Angola, Benin, Botswana...",
            "122" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "119" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "121" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "123" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "126" => "ZONA AF: Angola, Benin, Botswana...",
            "124" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "125" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "127" => "ZONA AF: Angola, Benin, Botswana...",
            "128" => "ZONA AF: Angola, Benin, Botswana...",
            "129" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "130" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "12" => "Zona EU1: Alemania, Austria,Bélgica...",
            "133" => "ZONA AF: Angola, Benin, Botswana...",
            "136" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "137" => "ZONA AF: Angola, Benin, Botswana...",
            "138" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "151" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "141" => "ZONA AF: Angola, Benin, Botswana...",
            "144" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "146" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "147" => "Zona EU1: Alemania, Austria,Bélgica...",
            "148" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "149" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "152" => "ZONA AF: Angola, Benin, Botswana...",
            "154" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "155" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "157" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "158" => "ZONA AF: Angola, Benin, Botswana...",
            "31" => "ZONA AF: Angola, Benin, Botswana...",
            "23" => "Zona EU1: Alemania, Austria,Bélgica...",
            "162" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "163" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "164" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "166" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "168" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "169" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "14" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "15" => "Zona EU1: Alemania, Austria,Bélgica...",
            "176" => "ZONA AF: Angola, Benin, Botswana...",
            "36" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "175" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "187" => "ZONA AF: Angola, Benin, Botswana...",
            "188" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "189" => "ZONA AF: Angola, Benin, Botswana...",
            "25" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "200" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "193" => "ZONA AF: Angola, Benin, Botswana...",
            "30" => "ZONA AF: Angola, Benin, Botswana...",
            "196" => "ZONA AF: Angola, Benin, Botswana...",
            "18" => "Zona EU1: Alemania, Austria,Bélgica...",
            "19" => "Zona EU1: Alemania, Austria,Bélgica...",
            "197" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "204" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "201" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "203" => "ZONA AF: Angola, Benin, Botswana...",
            "202" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "33" => "ZONA AF: Angola, Benin, Botswana...",
            "206" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "208" => "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "210" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "209" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "212" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "214" => "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "213" => "ZONA AF: Angola, Benin, Botswana...",
            "216" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "217" => "ZONA AS-OC 2: Australia, Nueva Zelanda...",
            "218" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "219" => "ZONA AM: Antigua y Barbuda, Argentina...",
            "220" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "225" => "ZONA AS-OC: Afganistán, Arabia Saudí...",
            "226" => "ZONA AF: Angola, Benin, Botswana...",
        ];

        foreach($zone_country_array as $id_country => $zone_name) {
            # Andorra: Zona 5
            if ($id_country == 40) {
                $id_zone = $db->getIDZone("Zona 9: Envíos a Portugal peninsular con origen Canarias");
                $db->updateCountryIDZone($id_country, $id_zone);
            } else {
                $id_zone = $db->getIDZone($zone_name);
                $db->updateCountryIDZone($id_country, $id_zone);
            }

        }

        /* ASIGN ZONE TO PROVINCIAS */

        $state_list = [
            "353" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "354" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "355" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "356" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "357" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "358" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "359" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "360" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "361" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "362" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "363" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "364" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "365" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "366" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "367" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "368" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "369" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "370" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "371" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "372" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "373" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "374" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "375" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "376" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "377" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "378" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "380" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "381" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "382" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "383" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "384" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "385" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "386" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "387" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "388" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "389" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "390" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "392" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "393" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "394" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "395" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "396" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "397" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "398" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "399" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "400" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "401" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "402" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "403" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "404" => "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "379" => "Zona 6: Envíos a Canarias interislas",
            "391" => "Zona 6: Envíos a Canarias interislas",
        ];

        foreach($state_list as $id_state => $zone_name) {
            $id_zone = $db->getIDZone($zone_name);
            $db->updateStateIDZone($id_state, $id_zone);
        }

        /* CREATE CARRIER */
        /* Zonas
             "Zona 1:Misma provincia (misma isla)"
             "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra"
             "Zona 6: Envíos a Canarias interislas"
             "Zona 9: Envíos a Portugal peninsular con origen Canarias"
             "Zona EU1: Alemania, Austria,Bélgica..."
             "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia..."
             "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina..."
             "ZONA AM: Antigua y Barbuda, Argentina..."
             "ZONA AS-OC: Afganistán, Arabia Saudí..."
             "ZONA AS-OC 2: Australia, Nueva Zelanda..."
             "ZONA AF: Angola, Benin, Botswana..."
        */

        /* Carta certificada: Nacional y Europeo hasta 1 kg */
        $carrier_name = "Cartas certificadas";
        $zones = [
            "Zona 1:Misma provincia (misma isla)",
            "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "Zona 6: Envíos a Canarias interislas",
            "Zona 9: Envíos a Portugal peninsular con origen Canarias",
            "Zona EU1: Alemania, Austria,Bélgica...",
            "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia..."];
        /* ranges: zones array position, start range, end range, price */
        $ranges = array (
            /* Zona 1 */
            array(1, 0.000000, 0.020000, 4.500000),
            array(1, 0.020000, 0.050000, 4.600000),
            array(1, 0.050000, 0.100000, 5.100000),
            array(1, 0.100000, 0.500000, 6.450000),
            array(1, 0.500000, 1.000000, 9.300000),
            /* Zona 5 */
            array(2, 0.000000, 0.020000, 4.500000),
            array(2, 0.020000, 0.050000, 4.600000),
            array(2, 0.050000, 0.100000, 5.100000),
            array(2, 0.100000, 0.500000, 6.450000),
            array(2, 0.500000, 1.000000, 9.300000),
            /* Zona 6 */
            array(3, 0.000000, 0.020000, 4.500000),
            array(3, 0.020000, 0.050000, 4.600000),
            array(3, 0.050000, 0.100000, 5.100000),
            array(3, 0.100000, 0.500000, 6.450000),
            array(3, 0.500000, 1.000000, 9.300000),
            /* Zona 9 */
            array(4, 0.000000, 0.020000, 6.450000),
            array(4, 0.020000, 0.050000, 6.750000),
            array(4, 0.050000, 0.100000, 7.550000),
            array(4, 0.100000, 0.500000, 11.700000),
            array(4, 0.500000, 1.000000, 18.100000),
            /* Zona EU1 */
            array(5, 0.000000, 0.020000, 6.450000),
            array(5, 0.020000, 0.050000, 6.750000),
            array(5, 0.050000, 0.100000, 7.550000),
            array(5, 0.100000, 0.500000, 11.700000),
            array(5, 0.500000, 1.000000, 18.100000),
            /* Zona EU2 */
            array(6, 0.000000, 0.020000, 6.450000),
            array(6, 0.020000, 0.050000, 6.750000),
            array(6, 0.050000, 0.100000, 7.550000),
            array(6, 0.100000, 0.500000, 11.700000),
            array(6, 0.500000, 1.000000, 18.100000)
        );

        $this->createCarrier($db, $carrier_name, $zones, $ranges);

        /* PAQUETE AZUL: Nacional hasta 20 kg */
        $carrier_name = "Paquete Azul";
        $zones = [
            "Zona 1:Misma provincia (misma isla)",
            "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "Zona 6: Envíos a Canarias interislas"
        ];
        /* ranges: zones array position, start range, end range, price */
        $ranges = array (
            /* Zona 1 */
            array(1, 0.000000, 1.000000, 15.000000),
            array(1, 1.000000, 2.000000, 16.850000),
            array(1, 2.000000, 5.000000, 21.250000),
            array(1, 5.000000, 10.000000, 25.300000),
            array(1, 10.000000, 15.000000, 36.850000),
            array(1, 15.000000, 20.000000, 44.350000),
            /* Zona 5 */
            array(2, 0.000000, 1.000000, 15.000000),
            array(2, 1.000000, 2.000000, 16.850000),
            array(2, 2.000000, 5.000000, 21.250000),
            array(2, 5.000000, 10.000000, 25.300000),
            array(2, 10.000000, 15.000000, 36.850000),
            array(2, 15.000000, 20.000000, 44.350000),
            /* Zona 6 */
            array(3, 0.000000, 1.000000, 15.000000),
            array(3, 1.000000, 2.000000, 16.850000),
            array(3, 2.000000, 5.000000, 21.250000),
            array(3, 5.000000, 10.000000, 25.300000),
            array(3, 10.000000, 15.000000, 36.850000),
            array(3, 15.000000, 20.000000, 44.350000)
        );

        $this->createCarrier($db, $carrier_name, $zones, $ranges);

        /* PAQUETE ESTÁNDAR: Nacional hasta 30 kg */
        $carrier_name = "Paquete Estándar";
        $zones = [
            "Zona 1:Misma provincia (misma isla)",
            "Zona 5: Península, Baleares, Ceuta, Melilla y Andorra",
            "Zona 6: Envíos a Canarias interislas",
            "Zona 9: Envíos a Portugal peninsular con origen Canarias"
        ];
        /* ranges: zones array position, start range, end range, price */
        $ranges = array (
            /* Zona 1 */
            array(1, 0.000000, 1.000000, 11.280000),
            array(1, 1.000000, 5.000000, 14.100000),
            array(1, 5.000000, 10.000000, 18.930000),
            array(1, 10.000000, 15.000000, 22.950000),
            array(1, 15.000000, 20.000000, 27.770000),
            array(1, 20.000000, 25.000000, 32.190000),
            array(1, 25.000000, 30.000000, 36.520000),
            /* Zona 5 */
            array(2, 0.000000, 1.000000, 19.850000),
            array(2, 1.000000, 5.000000, 28.650000),
            array(2, 5.000000, 10.000000, 35.850000),
            array(2, 10.000000, 15.000000, 45.800000),
            array(2, 15.000000, 20.000000, 60.300000),
            array(2, 20.000000, 25.000000, 81.050000),
            array(2, 25.000000, 30.000000, 99.800000),
            /* Zona 6 */
            array(3, 0.000000, 1.000000, 10.540000),
            array(3, 1.000000, 5.000000, 13.180000),
            array(3, 5.000000, 10.000000, 17.690000),
            array(3, 10.000000, 15.000000, 21.450000),
            array(3, 15.000000, 20.000000, 25.950000),
            array(3, 20.000000, 25.000000, 30.080000),
            array(3, 25.000000, 30.000000, 34.130000),
            /* Zona 9 */
            array(4, 0.000000, 1.000000, 22.050000),
            array(4, 1.000000, 5.000000, 35.290000),
            array(4, 5.000000, 10.000000, 42.000000),
            array(4, 10.000000, 15.000000, 53.550000),
            array(4, 15.000000, 20.000000, 80.500000),
            array(4, 20.000000, 25.000000, 99.750000),
            array(4, 25.000000, 30.000000, 123.900000)
        );

        $this->createCarrier($db, $carrier_name, $zones, $ranges);

        /* PAQUETE STANDARD INTERNACIONAL: Internacional hasta 5 kg */
        $carrier_name = "Paquete Standard Internacional";
        $zones = [
            "Zona EU1: Alemania, Austria,Bélgica...",
            "ZONA EU2: Argelia, Bulgaria, Chipre, Croacia...",
            "ZONA EU3: Albania, Bielorrusia, Bosnia Herzegovina...",
            "ZONA AM: Antigua y Barbuda, Argentina..."
        ];
        /* ranges: zones array position, start range, end range, price */
        $ranges = array (
            /* Zona EU1 */
            array(1, 0.000000, 1.000000, 26.160000),
            array(1, 1.000000, 2.000000, 28.930000),
            array(1, 2.000000, 3.000000, 31.700000),
            array(1, 3.000000, 4.000000, 34.470000),
            array(1, 4.000000, 5.000000, 37.240000),
            /* Zona EU2 */
            array(2, 0.000000, 1.000000, 27.690000),
            array(2, 1.000000, 2.000000, 31.330000),
            array(2, 2.000000, 3.000000, 34.970000),
            array(2, 3.000000, 4.000000, 38.610000),
            array(2, 4.000000, 5.000000, 42.250000),
            /* Zona EU3 */
            array(3, 0.000000, 1.000000, 27.690000),
            array(3, 1.000000, 2.000000, 37.810000),
            array(3, 2.000000, 3.000000, 47.930000),
            array(3, 3.000000, 4.000000, 58.050000),
            array(3, 4.000000, 5.000000, 68.170000),
            /* Zona AM */
            array(4, 0.000000, 1.000000, 36.850000),
            array(4, 1.000000, 2.000000, 46.400000),
            array(4, 2.000000, 3.000000, 55.950000),
            array(4, 3.000000, 4.000000, 65.500000),
            array(4, 4.000000, 5.000000, 75.050000)
        );

        $this->createCarrier($db, $carrier_name, $zones, $ranges);

        return true;
    }

    public function createCarrier($db, $carrier_name, $zones_list, $ranges_multi_list)
    {

        /* New carrier */
        $db->insertCarrier($carrier_name);
        $id_carrier = $db->getIDCarrier($carrier_name);

        /* Copy carrier logo */
        copy(dirname(__FILE__).'/views/img/logo-correos.jpg', _PS_SHIP_IMG_DIR_.'/'.$id_carrier.'.jpg');

        /* User groups */
        $db->insertCarrierGroup($id_carrier, 1);
        $db->insertCarrierGroup($id_carrier, 2);
        $db->insertCarrierGroup($id_carrier, 3);

        /* Lang */
        $db->insertCarrierLang($id_carrier, "Entrega a domicilio entre 5 - 7 días laborables");

        /* Shop */
        $db->insertCarrierShop($id_carrier);

        /* Tax rules */
        $db->insertCarrierTaxRules($id_carrier);

        /* Zones */
        $pos = 1;
        foreach($zones_list as $zone_name) {

            $id_zone = $db->getIDZone($zone_name);
            $db->insertCarrierZone($id_carrier, $id_zone);

            /* Ranges */
            for ($i = 0; $i < count($ranges_multi_list); $i++)
            {
                if ($pos == $ranges_multi_list[$i][0])
                {
                    if ($db->checkRangeWeight($id_carrier, $ranges_multi_list[$i][1], $ranges_multi_list[$i][2]) == NULL)
                    {
                        $db->insertCarrierRangeWeight($id_carrier, $ranges_multi_list[$i][1], $ranges_multi_list[$i][2]);
                        $id_range_weight = $db->getIDCarrierRangeWeight($id_carrier, $ranges_multi_list[$i][1], $ranges_multi_list[$i][2]);
                        $db->insertCarrierRangePrice($id_carrier, $id_zone, $id_range_weight, $ranges_multi_list[$i][3]);
                    }
                    else
                    {
                        $id_range_weight = $db->checkRangeWeight($id_carrier, $ranges_multi_list[$i][1], $ranges_multi_list[$i][2]);
                        $db->insertCarrierRangePrice($id_carrier, $id_zone, $id_range_weight, $ranges_multi_list[$i][3]);
                    }

                }

            }

            $pos = $pos + 1;

        }


    }

    public function uninstallDB()
    {

        include "classes/db_backup.php";
        $db_backup = new DBBackup();

        /* RESTORE TABLES */

        /* Table: ps_country */
        $db_backup->truncateTable('country');
        $db_backup->restorePSCountry();
        $db_backup->deleteTablePSCountryBackup();

        /* Table: ps_state */
        $db_backup->truncateTable('state');
        $db_backup->restorePSStateShop();
        $db_backup->deleteTablePSStateBackup();

        return true;
    }

}
