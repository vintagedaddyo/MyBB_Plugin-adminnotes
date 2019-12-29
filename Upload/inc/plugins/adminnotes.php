<?php
/*
 * MyBB: Admin Notes
 *
 * File: adminnotes.php
 * 
 * Authors: Edson Ordaz, Vintagedaddyo
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.1
 * 
 */

function adminnotes_info()
{
    global $lang;
    
    $lang->load("adminnotes");
    
    $lang->adminnotes_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' . '<input type="hidden" name="cmd" value="_s-xclick">' . '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' . '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' . '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' . '</form>' . $lang->adminnotes_Desc;
    
    return Array(
        'name' => $lang->adminnotes_Name,
        'description' => $lang->adminnotes_Desc,
        'website' => $lang->adminnotes_Web,
        'author' => $lang->adminnotes_Auth,
        'authorsite' => $lang->adminnotes_AuthSite,
        'version' => $lang->adminnotes_Ver,
        'compatibility' => $lang->adminnotes_Compat
    );
}

function adminnotes_is_installed()
{
    global $mybb, $db;

    if ($db->table_exists("adminnotes")) {
        return true;
    }
}

function adminnotes_install()
{
    global $db, $lang;
    
    $lang->load("adminnotes");
    
    if (!$db->table_exists("adminnotes")) {
        $db->query("CREATE TABLE IF NOT EXISTS `" . TABLE_PREFIX . "adminnotes` (
          `nid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
          `uid` varchar(120) NOT NULL DEFAULT '',
          `text` text NOT NULL,
          PRIMARY KEY (`nid`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    }
    
    $adminnotes_groups = array(
        "gid" => "0",
        "name" => "adminnotes",
        "title" => $lang->adminnotes_setting_0_Title,
        "description" => $lang->adminnotes_setting_0_Description,
        "disporder" => "0",
        "isdefault" => "0"
    );

    $db->insert_query("settinggroups", $adminnotes_groups);

    $gid        = $db->insert_id();
    
    $adminnotes = array(
        array(
            "name" => "adminnotes_pagination",
            "title" => $lang->adminnotes_setting_1_Title,
            "description" => $lang->adminnotes_setting_1_Description,
            "optionscode" => "text",
            "value" => "15",
            "disporder" => 1,
            "gid" => $gid
        )
    );

    foreach ($adminnotes as $adminnotesinstall)

    $db->insert_query("settings", $adminnotesinstall);

    rebuild_settings();
}

function adminnotes_deactivate()
{
    global $db;

    $db->drop_table("adminnotes");

    $db->query("DELETE FROM " . TABLE_PREFIX . "settinggroups WHERE name='adminnotes'");

    $db->delete_query("settings", "name LIKE 'adminnotes_%'");
}

function adminnotes_uninstall()
{
    global $db;

    $db->drop_table("adminnotes");

    $db->query("DELETE FROM " . TABLE_PREFIX . "settinggroups WHERE name='adminnotes'");

    $db->delete_query("settings", "name LIKE 'adminnotes_%'");
}
?>
