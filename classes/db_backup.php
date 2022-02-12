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

class DBBackup
{

    /* Create table ps_zone_backup */
    public function createTablePSZoneBackup()
    {
        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'zone_backup` (
                `id_zone` INT(10) UNSIGNED UNIQUE AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(64) NOT NULL,
                `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0
            ) ENGINE = '._MYSQL_ENGINE_.' CHARACTER SET utf8 COLLATE utf8_general_ci;
        ');

        return true;
    }
    /* Delete table ps_zone_backup */
    public function deleteTablePSZoneBackup()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'zone_backup`;');

        return true;
    }
    /* Create backup from ps_zone to ps_zone_backup table */
    public function backupPSZone()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'zone_backup` SELECT * FROM `'._DB_PREFIX_.'zone`;');

        return true;
    }
    /* Restore backup from ps_zone_backup to ps_zone table */
    public function restorePSZone()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'zone` SELECT * FROM `'._DB_PREFIX_.'zone_backup`;');

        return true;
    }

    /* Create table ps_zone_shop_backup */
    public function createTablePSZoneShopBackup()
    {
        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'zone_shop_backup` (
                `id_zone` INT(11) UNSIGNED UNIQUE PRIMARY KEY,
                `id_shop` INT(11) UNSIGNED NOT NULL
            ) ENGINE = '._MYSQL_ENGINE_.' CHARACTER SET utf8 COLLATE utf8_general_ci;
        ');

        return true;
    }
    /* Delete table ps_zone_shopbackup */
    public function deleteTablePSZoneShopBackup()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'zone_shop_backup`;');

        return true;
    }
    /* Create backup from ps_zone to ps_zone_backup table */
    public function backupPSZoneShop()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'zone_shop_backup` SELECT * FROM `'._DB_PREFIX_.'zone_shop`;');

        return true;
    }

    /* Truncate any table */
    public function truncateTable($table)
    {
        Db::getInstance()->query('TRUNCATE TABLE `'._DB_PREFIX_.$table.'`;');

        return true;
    }
    /* Restore backup from ps_zone_shop_backup to ps_zone_shop table */
    public function restorePSZoneShop()
    {
        Db::getInstance()->query('INSERT INTO `'._DB_PREFIX_.'zone_shop` SELECT * FROM `'._DB_PREFIX_.'zone_shop_backup`;');

        return true;
    }



}
