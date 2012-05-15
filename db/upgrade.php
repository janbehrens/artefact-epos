<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-internal
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2006-2009 Catalyst IT Ltd http://catalyst.net.nz
 *
 */

defined('INTERNAL') || die();

function xmldb_artefact_epos_upgrade($oldversion=0) {
    
    if ($oldversion < 2012051400) {
        $table = new XMLDBTable('artefact_epos_biography_educationhistory');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('startdate', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('enddate', XMLDB_TYPE_TEXT, null, null, null);
        $table->addFieldInfo('place', XMLDB_TYPE_TEXT, null, null, null);
        $table->addFieldInfo('subject', XMLDB_TYPE_TEXT, null, null, null);
        $table->addFieldInfo('level', XMLDB_TYPE_TEXT, null, null, null);
        $table->addFieldInfo('description', XMLDB_TYPE_TEXT, null, null, null);
        $table->addFieldInfo('displayorder', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addKeyInfo('biography_educationhistory_pk', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('artefactfk', XMLDB_KEY_FOREIGN, array('artefact'), 'artefact', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
    }
    
    return true;
}

