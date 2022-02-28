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

class DBBackup
{

    /* Create table ps_country_backup */
    public function createTablePSCountryBackup()
    {
        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'country_backup` (
                `id_country` INT(10) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
                `id_zone` INT(10) UNSIGNED NOT NULL,
                `id_currency` INT(10) UNSIGNED NOT NULL DEFAULT 0,
                `iso_code` VARCHAR(3) NOT NULL,
                `call_prefix` INT(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
                `contains_states` TINYINT(1) NOT NULL DEFAULT 0,
                `need_identification_number` TINYINT(1) NOT NULL DEFAULT 0,
                `need_zip_code` TINYINT(1) NOT NULL DEFAULT 1,
                `zip_code_format` VARCHAR(12) NOT NULL,
                `display_tax_label` TINYINT(1) NOT NULL
            ) ENGINE = '._MYSQL_ENGINE_.' CHARACTER SET utf8 COLLATE utf8_general_ci;
        ');

        return true;
    }
    /* Delete table ps_country_backup */
    public function deleteTablePSCountryBackup()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'country_backup`;');

        return true;
    }
    /* Create backup from ps_zone to ps_zone_backup table */
    public function backupPSCountry()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'country_backup` SELECT * FROM `'._DB_PREFIX_.'country`;');

        return true;
    }
    /* Restore backup from ps_country_backup to ps_country table */
    public function restorePSCountry()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'country` SELECT * FROM `'._DB_PREFIX_.'country_backup`;');

        return true;
    }

    /* Create table ps_state_backup */
    public function createTablePSStateBackup()
    {
        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'state_backup` (
                `id_state` INT(10) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
                `id_country` INT(11) UNSIGNED NOT NULL,
                `id_zone` INT(11) UNSIGNED NOT NULL,
                `name` VARCHAR(64) NOT NULL,
                `iso_code` VARCHAR(7) NOT NULL,
                `tax_behavior` TINYINT(1) NOT NULL DEFAULT 0,
                `active` TINYINT(1) NOT NULL DEFAULT 0
            ) ENGINE = '._MYSQL_ENGINE_.' CHARACTER SET utf8 COLLATE utf8_general_ci;
        ');

        return true;
    }
    /* Delete table ps_state_backup */
    public function deleteTablePSStateBackup()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'state_backup`;');

        return true;
    }
    /* Create backup from ps_state to ps_state_backup table */
    public function backupPSState()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'state_backup` SELECT * FROM `'._DB_PREFIX_.'state`;');

        return true;
    }

    /* Truncate any table */
    public function truncateTable($table)
    {
        Db::getInstance()->query('TRUNCATE TABLE `'._DB_PREFIX_.$table.'`;');

        return true;
    }
    /* Restore backup from ps_state_backup to ps_state table */
    public function restorePSStateShop()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'state` SELECT * FROM `'._DB_PREFIX_.'state_backup`;');

        return true;
    }



}
