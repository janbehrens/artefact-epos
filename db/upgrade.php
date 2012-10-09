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

safe_require('artefact', 'epos');

function xmldb_artefact_epos_upgrade($oldversion=0) {
    
    if ($oldversion < 2012060500) {
        $plugindir = get_config('docroot') . 'artefact/epos/';
        
        //-------artefact-------
        
        if (is_postgres()) {
            execute_sql('ALTER TABLE artefact DROP CONSTRAINT arte_art_fk');
        }
        else {
            execute_sql('ALTER TABLE artefact DROP FOREIGN KEY arte_art_fk');
        }
        execute_sql("UPDATE artefact SET artefacttype = 'subject' WHERE artefacttype = 'learnedlanguage'");
        execute_sql("UPDATE artefact_installed_type SET name = 'subject' WHERE name = 'learnedlanguage'");
        execute_sql('ALTER TABLE artefact
                ADD CONSTRAINT arte_art_fk FOREIGN KEY (artefacttype)
                REFERENCES artefact_installed_type (name)
                MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION');
        
        //-------artefact_epos_subject-------
        
        $table = new XMLDBTable('artefact_epos_subject');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('institution', XMLDB_TYPE_CHAR, 255, null, XMLDB_NOTNULL);
        $table->addFieldInfo('active', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL);
        $table->addKeyInfo('pk', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('institutionfk', XMLDB_KEY_FOREIGN, array('institution'), 'institution', array('name'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        
        $values = array('id' => null, 'name' => 'Sprachen', 'institution' => 'mahara', 'active' => 1);
        $subject_id = insert_record('artefact_epos_subject', (object)($values), 'id', true);
        
        //-------artefact_epos_artefact_subject-------
        
        $table = new XMLDBTable('artefact_epos_artefact_subject');
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('subject', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addKeyInfo('artefactfk', XMLDB_KEY_FOREIGN, array('artefact'), 'artefact', array('id'));
        $table->addKeyInfo('subjectfk', XMLDB_KEY_FOREIGN, array('subject'), 'artefact_epos_subject', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        
        execute_sql("INSERT INTO artefact_epos_artefact_subject 
                SELECT id as artefact, $subject_id FROM artefact WHERE artefacttype = 'subject'");
        execute_sql("ALTER TABLE artefact_epos_artefact_subject
                ALTER subject DROP DEFAULT");
                
        //-------artefact_epos_descriptor_set-------
        
        $table = new XMLDBTable('artefact_epos_descriptor_set');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('file', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('visible', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('active', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL);
        $table->addKeyInfo('pk', XMLDB_KEY_PRIMARY, array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        
        //-------artefact_epos_descriptorset_subject-------
        
        $table = new XMLDBTable('artefact_epos_descriptorset_subject');
        $table->addFieldInfo('descriptorset', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('subject', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, null, $subject_id);
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset'), 'artefact_epos_descriptor_set', array('id'));
        $table->addKeyInfo('subjectfk', XMLDB_KEY_FOREIGN, array('subject'), 'artefact_epos_subject', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        
        //-------artefact_epos_descriptor-------
        
        $table = new XMLDBTable('artefact_epos_descriptor');
        drop_table($table);
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('link', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('competence', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('level', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('evaluations', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('goal_available', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('descriptorset', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL);
        $table->addKeyInfo('pk', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset'), 'artefact_epos_descriptor_set', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        
        //-------artefact_epos_checklist_item-------
        
        execute_sql('ALTER TABLE artefact_epos_checklist_item
                ADD COLUMN descriptorint bigint');

        $descriptorsets = array('cercles.de', 'cercles.en', 'elc.de', 'elc.en', 'elc.fr', 'schule.de');
        $competence_new_to_old = array(
                'Hörverstehen' => 'li',
                'Lesen' => 're',
                'Schreiben' => 'wr',
                'Zusammenhängend sprechen' => 'sp',
                'Miteinander sprechen' => 'si',
                'Listening' => 'li',
                'Reading' => 're',
                'Writing' => 'wr',
                'Spoken production' => 'sp',
                'Spoken interaction' => 'si',
                'Ecouter' => 'li',
                'Lire' => 're',
                'Ecrire' => 'wr',
                'S’exprimer oralement en continu' => 'sp',
                'Prendre part à une conversation' => 'si',
        );
        
        foreach ($descriptorsets as $set) {
            $dataroot = realpath(get_config('dataroot'));
            $xml = "$dataroot/artefact/epos/descriptorsets/$set.xml";
            $xmlcontents = file_get_contents($xml);
            $xmlarr = xmlize($xmlcontents);
            
            $descriptorsettable = 'artefact_epos_descriptor_set';
            $descriptortable = 'artefact_epos_descriptor';
            
            $descriptorset_newname = $values['name'] = $xmlarr['DESCRIPTORSET']['@']['NAME'];
            $values['file'] = "$set.xml";
            $values['visible'] = 1;
            $values['active'] = 1;
            $values['descriptorset'] = insert_record($descriptorsettable, (object)($values), 'id', true);
            
            insert_record('artefact_epos_descriptorset_subject', (object)($values));
            
            $i = 0;
            $prev_level = '';
            foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
                $values['name']       = $x['@']['NAME'];
                $values['link']       = $x['@']['LINK'];
                $values['competence'] = $x['@']['COMPETENCE'];
                $values['level']      = $x['@']['LEVEL'];
                $values['evaluations'] = $x['@']['EVALUATIONS'];
                $values['goal_available'] = $x['@']['GOAL'];
                
                $i = $prev_level != $values['level'] ? 1 : $i+1;
                $prev_level = $values['level'];
                
                $descriptor_old = str_replace('.', '_', $set) . '_'
                        . $competence_new_to_old[$values['competence']] . '_'
                        . strtolower($values['level']) . '_'
                        . $i;
                
                $descriptor_new = insert_record($descriptortable, (object)($values), 'id', true);
                
                execute_sql("UPDATE artefact_epos_checklist_item 
                        SET descriptorint=$descriptor_new 
                        WHERE descriptor='$descriptor_old'");
            }
            execute_sql("UPDATE artefact 
                    SET title = '$descriptorset_newname' 
                    WHERE artefacttype = 'checklist' AND title='$set'");
        }
        
        execute_sql('ALTER TABLE artefact_epos_checklist_item 
                DROP COLUMN descriptor');
        execute_sql('ALTER TABLE artefact_epos_checklist_item 
                DROP COLUMN id');
        execute_sql('DELETE FROM artefact_epos_checklist_item 
                WHERE descriptorint IS NULL');
        if (is_postgres()) {
            execute_sql('ALTER TABLE artefact_epos_checklist_item 
                    ALTER COLUMN descriptorint SET NOT NULL');
            execute_sql('ALTER TABLE artefact_epos_checklist_item 
                    RENAME descriptorint TO descriptor');
            execute_sql('ALTER TABLE artefact_epos_checklist_item 
                    ALTER COLUMN goal DROP NOT NULL');
        }
        else {
            execute_sql('ALTER TABLE artefact_epos_checklist_item 
                    CHANGE descriptorint descriptor bigint(10) NOT NULL');
            execute_sql('ALTER TABLE artefact_epos_checklist_item
                    MODIFY goal bigint(10)');
        }
        execute_sql('ALTER TABLE artefact_epos_checklist_item
                ADD CONSTRAINT arteeposchecitem_des_fk FOREIGN KEY (descriptor) 
                REFERENCES artefact_epos_descriptor (id) 
                MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION');
        execute_sql("ALTER TABLE artefact_epos_descriptorset_subject
                ALTER subject DROP DEFAULT");
    }
    
    if ($oldversion < 2012092301) {
        $table = new XMLDBTable('artefact_epos_biography_educationhistory');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('startdate', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('enddate', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('place', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('subject', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('level', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('description', XMLDB_TYPE_TEXT);
        $table->addFieldInfo('displayorder', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addKeyInfo('pk', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('artefactfk', XMLDB_KEY_FOREIGN, array('artefact'), 'artefact', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }

        execute_sql("INSERT INTO artefact_installed_type VALUES ('biography', 'epos')");
    }
    
    return true;
}

