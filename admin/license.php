<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2015 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

require_once '../lib/init.php';

if (!Access::check('interface','100')) {
    UI::access_denied();
    exit;
}

UI::show_header();

switch ($_REQUEST['action']) {
    case 'edit':
        if (isset($_POST['license_id'])) {
            $license = new License($_POST['license_id']);
            if ($license->id) {
                $license->update($_POST);
            }
            $text = T_('License Updated');
        } else {
            License::create($_POST);
            $text = T_('License Created');
        }
        show_confirmation($text,'',AmpConfig::get('web_path').'/admin/license.php');
    break;
    case 'show_edit':
        $license = new License($_REQUEST['license_id']);
    case 'show_create':
        require_once AmpConfig::get('prefix') . '/templates/show_edit_license.inc.php';
        break;
    case 'delete':
        License::delete($_REQUEST['license_id']);
        show_confirmation(T_('License Deleted'),'',AmpConfig::get('web_path').'/admin/license.php');
    break;
    default:
        $browse = new Browse();
        $browse->set_type('license');
        $browse->set_simple_browse(true);
        $license_ids = $browse->get_objects();
        $browse->show_objects($license_ids);
        $browse->store();
    break;
}

UI::show_footer();
