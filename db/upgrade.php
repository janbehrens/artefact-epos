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
 * @subpackage artefact-epos
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 TZI / Universität Bremen
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

    if ($oldversion < 2013060500) {
        $table = new XMLDBTable('artefact_epos_biography_certificates');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('date', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL);
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
    }

    if ($oldversion < 2013070200) {
        global $db;
        db_begin();
        // this version does not have the biography any more, but biography artefacts still exist
        // so we temporarily reassign them to internal
        update_record('artefact_installed_type', (object) array('plugin'=>'internal'), array('name' => 'biography'));
        // now we create a fake artefact type...
        insert_record('artefact_installed_type', (object) array(
            'plugin'=>'internal','name' => 'biography_tmp'
        ));
        // .. to which we assign the existing biography artefacts
        // we cannot use update_record() because it does not allow to use the same columns
        // for update as for where
        $sql = "UPDATE " . db_table_name('artefact') . " SET artefacttype='biography_tmp' WHERE artefacttype='biography'";
        $stmt = $db->Prepare($sql);
        $rs = $db->Execute($stmt);
        // same procedure with blocktype: uninstall the plugin but keep the instances
        insert_record('blocktype_installed', (object) array(
            'name' => 'biography_tmp',
            'version' => 0,
            'release' => '0',
            'active' => 0
        ));
        $sql = "UPDATE " . db_table_name('block_instance') . " SET blocktype='biography_tmp' WHERE blocktype='biography'";
        $stmt = $db->Prepare($sql);
        $rs = $db->Execute($stmt);
        // now, we can delete the biography artefact and block types
        delete_records('artefact_installed_type', 'plugin', 'internal', 'name', 'biography');
        delete_records('blocktype_installed_viewtype', 'blocktype', 'biography');
        delete_records('blocktype_installed_category', 'blocktype', 'biography');
        delete_records('blocktype_installed', 'name', 'biography');
        // the biography plugin will pick up form here
        $table = new XMLDBTable('artefact_epos_biography_educationhistory');
        rename_table($table, 'artefact_biography_educationhistory');
        $table = new XMLDBTable('artefact_epos_biography_certificates');
        rename_table($table, 'artefact_biography_certificates');
        db_commit();
    }

    if ($oldversion < 2013071800) {
        db_begin();
        $table = new XMLDBTable('artefact_epos_level');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('descriptorset_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL);
        $table->addKeyInfo('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset_id'), 'artefact_epos_descriptor_set', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        $table = new XMLDBTable('artefact_epos_competence');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('descriptorset_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL);
        $table->addKeyInfo('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset_id'), 'artefact_epos_descriptor_set', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        $table = new XMLDBTable('artefact_epos_rating');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('descriptorset_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL);
        $table->addKeyInfo('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset_id'), 'artefact_epos_descriptor_set', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        // split up artefact_epos_descriptor -> _level + _competence + _rating
        // first create all level, competence and rating records with proper links to the sets
        $sets = get_records_array('artefact_epos_descriptor_set');
        $maps = array();
        foreach ($sets as $set) {
            $descriptors = get_records_array('artefact_epos_descriptor', 'descriptorset', $set->id);
            if (count($descriptors) > 0) {
                $competences = array();
                $levels = array();
                $ratings = array();
                // gather data
                foreach ($descriptors as $descriptor) {
                    $competences[$descriptor->competence] = 0;
                    $levels[$descriptor->level] = 0;
                    $ratings[$descriptor->evaluations] = 0;
                }
                // write to tables and store id mapping
                foreach (array_keys($competences) as $competencename) {
                    $competence = new stdClass();
                    $competence->name = $competencename;
                    $competence->descriptorset_id = $set->id;
                    $cid = insert_record('artefact_epos_competence', $competence, 'id', true);
                    $competences[$competencename] = $cid;
                }
                foreach (array_keys($levels) as $levelname) {
                    $level = new stdClass();
                    $level->name = $levelname;
                    $level->descriptorset_id = $set->id;
                    $lid = insert_record('artefact_epos_level', $level, 'id', true);
                    $levels[$levelname] = $lid;
                }
                $real_ratings = array();
                foreach (array_keys($ratings) as $rating) {
                    $ratingnames = array_map('trim', explode(';', $rating));
                    foreach ($ratingnames as $ratingname) {
                        $rating = new stdClass();
                        $rating->name = $ratingname;
                        $rating->descriptorset_id = $set->id;
                        $rid = insert_record('artefact_epos_rating', $rating, 'id', true);
                        $real_ratings[$ratingname] = $rid;
                    }
                }
                $maps[$set->id] = array('competences' => $competences,
                                        'levels' => $levels,
                                        'ratings' => $real_ratings);
            }
        }
        // adjust table layout
        $table = new XMLDBTable('artefact_epos_descriptor');
        $competence_field = new XMLDBField('competence_id');
        $competence_field->type = XMLDB_TYPE_INTEGER;
        $competence_field->unsigned = true;
        $competence_field->length = 10;
        add_field($table, $competence_field);
        $level_field = new XMLDBField('level_id');
        $level_field->type = XMLDB_TYPE_INTEGER;
        $level_field->unsigned = true;
        $level_field->length = 10;
        add_field($table, $level_field);
        // fill the new id columns
        foreach ($maps as $set_id => $map) {
            $competences = $map['competences'];
            $levels = $map['levels'];
            foreach ($competences as $competence => $competence_id) {
                $data = (object) array('descriptorset' => $set_id,
                        'competence' => $competence,
                        'competence_id' => $competence_id);
                update_record('artefact_epos_descriptor', $data, array('descriptorset', 'competence'));
            }
            foreach ($levels as $level => $level_id) {
                $data = (object) array('descriptorset' => $set_id,
                        'level' => $level,
                        'level_id' => $level_id);
                update_record('artefact_epos_descriptor', $data, array('descriptorset', 'level'));
            }
        }
        // remove superfluous columns
        drop_field($table, new XMLDBField('competence'));
        drop_field($table, new XMLDBField('level'));
        drop_field($table, new XMLDBField('evaluations'));
        db_commit();
    }

    if ($oldversion < 2013081300) {
        $table = new XMLDBTable('artefact_epos_descriptor_set');
        rename_table($table, 'artefact_epos_descriptorset', false, false);
        $table = new XMLDBTable('artefact_epos_checklist_item');
        if (is_mysql()) {
            execute_sql('ALTER TABLE `artefact_epos_checklist_item` ADD `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        }
        else {
            $field = new XMLDBField('id');
            $field->setAttributes(XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
            add_field($table, $field);
            $key = new XMLDBKey('primary');
            $key->setAttributes(XMLDB_KEY_PRIMARY, array('id'), null, null);
            add_key($table, $key);
        }
        $field = new XMLDBField('type');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', true, XMLDB_NOTNULL, false, false, null, '0');
        add_field($table, $field);
        $field = new XMLDBField('goal');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', true, false, false, false, null, '0');
        change_field_type($table, $field);
        rename_table($table, 'artefact_epos_evaluation_item', false, false);
        $table = new XMLDBTable('artefact_epos_evaluation');
        if (table_exists($table)) {
            drop_table($table);
        }
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', false, XMLDB_NOTNULL);
        $table->addFieldInfo('descriptorset_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addKeyInfo('primary', XMLDB_KEY_PRIMARY, array('artefact'));
        $table->addKeyInfo('artefactfk', XMLDB_KEY_FOREIGN, array('artefact'), 'artefact', array('id'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset_id'), 'artefact_epos_descriptorset', array('id'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        // fill the new table with data from existing "checklists"
        $evaluations = get_records_array('artefact', 'artefacttype', 'checklist');
        foreach ($evaluations as $evaluation) {
            $sql = "SELECT d.descriptorset
                    FROM artefact_epos_descriptor d
                    RIGHT JOIN artefact_epos_evaluation_item i ON d.id = i.descriptor
                    WHERE i.checklist = ?
                    LIMIT 1";
            $item_record = get_record_sql($sql, array($evaluation->id));
            if ($item_record) {
                $data = (object) array(
                    'artefact' => $evaluation->id,
                    'descriptorset_id' => $item_record->descriptorset
                );
                insert_record('artefact_epos_evaluation', $data);
            }
        }
    }

    if ($oldversion < 2013082000) {
        // delete foreign keys first so fields can be renamed (for mysql)
        if (is_mysql()) {
            execute_sql("ALTER TABLE `artefact_epos_evaluation_item` DROP FOREIGN KEY `arteeposchecitem_che_fk`;");
            execute_sql("ALTER TABLE `artefact_epos_evaluation_item` DROP FOREIGN KEY `arteeposchecitem_des_fk`;");
        }
        $table = new XMLDBTable('artefact_epos_evaluation_item');
        $field = new XMLDBField('checklist');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10');
        rename_field($table, $field, 'evaluation_id');
        $field = new XMLDBField('evaluation');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10');
        rename_field($table, $field, 'value');
        $field = new XMLDBField('descriptor');
        // allow null
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10');
        change_field_type($table, $field);
        rename_field($table, $field, 'descriptor_id');
        // add a key to arbitrary items
        $field = new XMLDBField('target_key');
        $field->setAttributes(XMLDB_TYPE_CHAR, '255');
        add_field($table, $field);
        // re-add the foreign keys
        $key = new XMLDBKey('arteeposevalitem_eva_fk');
        $key->setAttributes(XMLDB_KEY_FOREIGN, array('evaluation_id'), 'artefact', array('id'));
        add_key($table, $key);
        $key = new XMLDBKey('arteeposevalitem_des_fk');
        $key->setAttributes(XMLDB_KEY_FOREIGN, array('descriptor_id'), 'artefact_epos_descriptor', array('id'));
        add_key($table, $key);
    }

    if ($oldversion < 2013091601) {
        // rename artefact type "checklist" to "evaluation"
        db_begin();
        insert_record('artefact_installed_type', (object) array(
            'name' => 'evaluation',
            'plugin' => 'epos'
        ));
        // we cannot use update_record() because it does not allow to use the same columns
        // for update as for where (Mahara bug)
        execute_sql("UPDATE artefact SET artefacttype = 'evaluation' WHERE artefacttype = 'checklist'");
        delete_records('artefact_installed_type', 'name', 'checklist', 'plugin', 'epos');
        // rename checklist blocks, too
        $blocktype = get_record('blocktype_installed', 'name', 'checklist', 'artefactplugin', 'epos');
        $blocktype->name = 'evaluation';
        insert_record('blocktype_installed', $blocktype);
        execute_sql("UPDATE block_instance SET blocktype = 'evaluation' WHERE blocktype = 'checklist'");
        execute_sql("UPDATE blocktype_installed_viewtype SET blocktype = 'evaluation' WHERE blocktype = 'checklist'");
        execute_sql("UPDATE blocktype_installed_category SET blocktype = 'evaluation' WHERE blocktype = 'checklist'");
        delete_records('blocktype_installed', 'name', 'checklist', 'artefactplugin', 'epos');
        db_commit();
    }

    if ($oldversion < 2013091601) {
        // install new artefact type "custom competence"
        insert_record('artefact_installed_type', (object) array(
            'name' => 'customcompetence',
            'plugin' => 'epos'
        ));
        // find users that have custom goals
        $usersSql = "SELECT owner AS id FROM artefact WHERE artefacttype = 'customgoal' GROUP BY owner";
        if ($users = get_records_sql_array($usersSql, array())) {
            // add custom competence for each user and evaluation and assign all goals to it
            foreach ($users as $user) {
                db_begin();
                $evaluationsSql = "SELECT DISTINCT checklist.*
                        FROM artefact customgoal
                        LEFT JOIN artefact subject ON customgoal.parent = subject.id
                        LEFT JOIN artefact checklist ON subject.id = checklist.parent
                        WHERE customgoal.artefacttype = 'customgoal'
                        AND checklist.artefacttype = 'checklist'
                        AND customgoal.owner = ?";
                if ($evaluations = get_records_sql_array($evaluationsSql, array($user->id))) {
                    foreach ($evaluations as $evaluation) {
                        $evaluation = new ArtefactTypeEvaluation(0, $evaluation);
                        $evaluation->set('dirty', false);
                        $competence = new ArtefactTypeCustomCompetence();
                        $competence->set('title', get_string('customgoaldefaulttitle', 'artefact.epos'));
                        $competence->set('parent', $evaluation->get('id'));
                        $competence->set('owner', $user->id);
                        $competence->commit();
                        $assignGoalsSql = "UPDATE artefact SET parent = ?
                                WHERE artefacttype = 'customgoal'
                                AND parent = ?
                                AND owner = ?";
                        execute_sql($assignGoalsSql, array($competence->get('id'), $evaluation->get('parent'), $user->id));
                        // create evaluation items for all goals
                        foreach ($competence->get_customgoals() as $customgoal) {
                            $evaluation->add_item(EVALUATION_ITEM_TYPE_CUSTOM_GOAL, null, $customgoal->get('id'), 1);
                        }
                    }
                    db_commit();
                }
            }
        }
    }

    if ($oldversion < 2013092300) {
        db_begin();
        $table = new XMLDBTable('artefact_epos_artefact_subject');
        // without primary key, the update will fail (mahara bug)
        if (is_mysql()) {
            execute_sql("ALTER TABLE `artefact_epos_artefact_subject` ADD PRIMARY KEY(`artefact`)");
        }
        else {
            $field = new XMLDBField('artefact');
            $field->setAttributes(XMLDB_TYPE_INTEGER, '10', false, XMLDB_NOTNULL, XMLDB_SEQUENCE);
            change_field_type($table, $field);
            $key = new XMLDBKey('primary');
            $key->setAttributes(XMLDB_KEY_PRIMARY, array('artefact'), null, null);
            add_key($table, $key);
        }
        if (is_postgres()) {
            // first rename the existing sequence to something the weird mahara mechanism accepts
            if (get_record('pg_class', 'relname', 'artefact_epos_artefact_subject_artefact_alter_column_tmp_seq1')) {
                execute_sql("ALTER TABLE artefact_epos_artefact_subject_artefact_alter_column_tmp_seq1 RENAME TO artefact_epos_artefact_subject_id_seq");
            }
            else {
                execute_sql("CREATE SEQUENCE artefact_epos_artefact_subject_id_seq");
            }
        }
        // eventually do the one operation we'd like to execute
        rename_table($table, 'artefact_epos_mysubject', false, false);
        db_commit();
    }

    if ($oldversion < 2013092401) {
        db_begin();
        $table = new XMLDBTable('artefact_epos_evaluation');
        $field = new XMLDBField('final');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', true, XMLDB_NOTNULL, null, null, null, 0);
        add_field($table, $field);
        $field = new XMLDBField('evaluator');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10', false, XMLDB_NOTNULL, null, null, null, 0);
        add_field($table, $field);
        $key = new XMLDBKey('evaluatorfk');
        $key->setAttributes(XMLDB_KEY_FOREIGN, array('evaluator'), 'usr', array('id'));
        add_key($table, $key);
        if (is_postgres()) {
            execute_sql("
                    UPDATE artefact_epos_evaluation SET evaluator = a.owner
                    FROM artefact_epos_evaluation e
                    INNER JOIN artefact a ON e.artefact = a.id
            ");
        }
        else if (is_mysql()) {
            execute_sql("
                    UPDATE artefact_epos_evaluation e
                    INNER JOIN artefact a ON e.artefact = a.id
                    SET e.evaluator = a.owner
            ");
        }
        else {
            throw new Exception("unsupported db dialect");
        }
        db_commit();
    }

    if ($oldversion < 2013092500) {
        db_begin();
        $table = new XMLDBTable('artefact_epos_evaluation_request');
        $table->addFieldInfo('id', XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->addFieldInfo('inquirer_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('evaluator_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('subject_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('descriptorset_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->addFieldInfo('evaluation_id', XMLDB_TYPE_INTEGER, '10', null, false);
        $table->addFieldInfo('inquiry_date', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL);
        $table->addFieldInfo('inquiry_message', XMLDB_TYPE_TEXT, null, null, false);
        $table->addFieldInfo('response_date', XMLDB_TYPE_DATETIME, null, null, false);
        $table->addFieldInfo('response_message', XMLDB_TYPE_TEXT, null, null, false);
        $table->addKeyInfo('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->addKeyInfo('inquirerfk', XMLDB_KEY_FOREIGN, array('inquirer_id'), 'usr', array('id'));
        $table->addKeyInfo('evaluatorfk', XMLDB_KEY_FOREIGN, array('evaluator_id'), 'usr', array('id'));
        $table->addKeyInfo('subjectfk', XMLDB_KEY_FOREIGN, array('subject_id'), 'artefact_epos_mysubject', array('artefact'));
        $table->addKeyInfo('descriptorsetfk', XMLDB_KEY_FOREIGN, array('descriptorset_id'), 'artefact_epos_descriptorset', array('id'));
        $table->addKeyInfo('evaluationfk', XMLDB_KEY_FOREIGN, array('evaluation_id'), 'artefact_epos_evaluation', array('artefact'));
        if (!create_table($table)) {
            throw new SQLException($table . " could not be created, check log for errors.");
        }
        db_commit();
    }

    if ($oldversion < 2013100100) {
        // find users that have custom goals
        $usersSql = "SELECT owner AS id FROM artefact WHERE artefacttype = 'customgoal' GROUP BY owner";
        $users = get_records_sql_array($usersSql, array());
        // add custom competence for each user and evaluation and assign all goals to it
        db_begin();
        foreach ($users as $user) {
            $competencesSql = "SELECT DISTINCT customcompetence.*
                    FROM artefact customcompetence
                    WHERE customcompetence.artefacttype = 'customcompetence'
                    AND customcompetence.owner = ?";
            $competences = get_records_sql_array($competencesSql, array($user->id));
            $evaluationsSql = "SELECT DISTINCT evaluation.*
                    FROM artefact customcompetence
                    LEFT JOIN artefact evaluation ON customcompetence.parent = evaluation.id
                    WHERE customcompetence.artefacttype = 'customcompetence'
                    AND evaluation.artefacttype = 'evaluation'
                    AND customcompetence.owner = ?";
            $evaluation_records = get_records_sql_array($evaluationsSql, array($user->id));
            $evaluations = array();
            foreach ($evaluation_records as $evaluation) {
                $evaluations[$evaluation->id] = new ArtefactTypeEvaluation($evaluation->id, $evaluation);
            }
            foreach ($competences as $competence) {
                $competence = new ArtefactTypeCustomCompetence($competence->id, $competence);
                $evaluation = $evaluations[$competence->get('parent')];
                // create evaluation items for all goals if not already exists
                foreach ($competence->get_customgoals() as $customgoal) {
                    if (!get_record('artefact_epos_evaluation_item', 'type', EVALUATION_ITEM_TYPE_CUSTOM_GOAL, 'target_key', $customgoal->get('id'))) {
                        $evaluation->add_item(EVALUATION_ITEM_TYPE_CUSTOM_GOAL, null, $customgoal->get('id'), 1);
                    }
                }
            }
        }
        db_commit();
    }

    if ($oldversion < 2015101600) {
        // Add 'inquirer_evaluation' to artefact_epos_evaluation_request
        $table = new XMLDBTable('artefact_epos_evaluation_request');
        $field = new XMLDBField('inquirer_evaluation');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10');
        add_field($table, $field);
    }

    if ($oldversion < 2015101700) {
        // Fix wrong column names
        $table = new XMLDBTable('artefact_epos_evaluation_request');
        $field = new XMLDBField('inquirer');
        rename_field($table, $field, 'inquirer_id');
        $field = new XMLDBField('evaluator');
        rename_field($table, $field, 'evaluator_id');
    }

    if ($oldversion < 2016020300) {
        // alter tables
        $competencetable = new XMLDBTable('artefact_epos_competence');
        $leveltable = new XMLDBTable('artefact_epos_level');
        $descriptortable = new XMLDBTable('artefact_epos_descriptor');
        $ratingtable = new XMLDBTable('artefact_epos_rating');
        $evaluationtable = new XMLDBTable('artefact_epos_evaluation');
        $evaluationitemtable = new XMLDBTable('artefact_epos_evaluation_item');
        $evaluationrequesttable = new XMLDBTable('artefact_epos_evaluation_request');
        $mysubjecttable = new XMLDBTable('artefact_epos_mysubject');

        $descriptorsetfield = new XMLDBField('descriptorset_id');
        $competencefield = new XMLDBField('competence_id');
        $levelfield = new XMLDBField('level_id');
        $evaluationfield = new XMLDBField('evaluation_id');
        $descriptorfield = new XMLDBField('descriptor_id');
        $inquirerfield = new XMLDBField('inquirer_id');
        $evaluatorfield = new XMLDBField('evaluator_id');
        $subjectfield = new XMLDBField('subject_id');

        $competencekey = new XMLDBKey('competencefk');
        $competencekey->setAttributes(XMLDB_KEY_FOREIGN, array('competence_id'), 'artefact_epos_competence', array('id'));
        $levelkey = new XMLDBKey('levelfk');
        $levelkey->setAttributes(XMLDB_KEY_FOREIGN, array('level_id'), 'artefact_epos_level', array('id'));
        $evaluatorevaluationkey = new XMLDBKey('evaluator_evaluationfk');
        $evaluatorevaluationkey->setAttributes(XMLDB_KEY_FOREIGN, array('evaluator_evaluation'), 'artefact_epos_evaluation', array('artefact'));
        $inquirerevaluationkey = new XMLDBKey('inquirer_evaluationfk');
        $inquirerevaluationkey->setAttributes(XMLDB_KEY_FOREIGN, array('inquirer_evaluation'), 'artefact_epos_evaluation', array('artefact'));

        drop_field($competencetable, $descriptorsetfield);
        drop_field($leveltable, $descriptorsetfield);
        add_key($descriptortable, $competencekey);
        add_key($descriptortable, $levelkey);
        rename_field($descriptortable, $competencefield, 'competence');
        rename_field($descriptortable, $levelfield, 'level');
        rename_field($ratingtable, $descriptorsetfield, 'descriptorset');
        rename_field($evaluationtable, $descriptorsetfield, 'descriptorset');
        rename_field($evaluationitemtable, $evaluationfield, 'evaluation');
        rename_field($evaluationitemtable, $descriptorfield, 'descriptor');
        rename_field($evaluationrequesttable, $inquirerfield, 'inquirer');
        rename_field($evaluationrequesttable, $evaluatorfield, 'evaluator');
        rename_field($evaluationrequesttable, $evaluationfield, 'evaluator_evaluation');
        rename_field($evaluationrequesttable, $descriptorsetfield, 'descriptorset');
        drop_field($evaluationrequesttable, $subjectfield);
        add_key($evaluationrequesttable, $inquirerevaluationkey);  // this doesn't seem to work

        // update artefact
        $sql = "SELECT a.*, b.title as parenttitle, b.artefacttype as parenttype FROM artefact a
                JOIN artefact b ON a.parent = b.id
                WHERE a.artefacttype = 'evaluation' OR a.artefacttype = 'customcompetence' OR a.artefacttype = 'customgoal'";
        if ($artefacts = get_records_sql_array($sql)) {
            foreach ($artefacts as $artefact) {
                if ($artefact->parenttype == 'subject' && $artefact->artefacttype == 'customgoal') {
                    delete_records('artefact', 'id', $artefact->id);
                }
                else {
                    if ($artefact->artefacttype == 'evaluation') {
                        $artefact->description = $artefact->title;
                        $artefact->title = $artefact->parenttitle;
                        $artefact->parent = null;
                    }
                    $artefact->path = substr($artefact->path, strpos($artefact->path, '/', 1));
                    update_record('artefact', $artefact);
                }
            }
        }
        delete_records('artefact_epos_mysubject');

        $sql = "SELECT va.* FROM view_artefact va
                JOIN artefact a ON va.artefact = a.id
                WHERE a.artefacttype = 'subject'";
        if ($records = get_records_sql_array($sql)) {
            foreach ($records as $record) {
                delete_records('view_artefact', 'id', $record->id);
                delete_records('block_instance', 'id', $record->block);
            }
        }
        delete_records('artefact', 'artefacttype', 'subject');

        // drop mysubject
        drop_table($mysubjecttable);
    }

    if ($oldversion < 2016021600) {
        // add primary key artefact_epos_descriptorset_subject
        $descriptorsetsubjecttable = new XMLDBTable('artefact_epos_descriptorset_subject');
        $primarykey = new XMLDBKey('primary');
        $primarykey->setAttributes(XMLDB_KEY_PRIMARY, array('descriptorset', 'subject'));
        add_key($descriptorsetsubjecttable, $primarykey);

        // create artefact_epos_evaluation_competencelevel
        $competenceleveltable = new XMLDBTable('artefact_epos_evaluation_competencelevel');
        $evaluationfield = new XMLDBField('evaluation');
        $evaluationfield->setAttributes(XMLDB_TYPE_INTEGER, 10, true, true);
        $competencefield = new XMLDBField('competence');
        $competencefield->setAttributes(XMLDB_TYPE_INTEGER, 10, true, true);
        $levelfield = new XMLDBField('level');
        $levelfield->setAttributes(XMLDB_TYPE_INTEGER, 10, true, false);
        $valuefield = new XMLDBField('value');
        $valuefield->setAttributes(XMLDB_TYPE_INTEGER, 10, true, true, null, null, null, 0);
        $primarykey = new XMLDBKey('primary');
        $primarykey->setAttributes(XMLDB_KEY_PRIMARY, array('evaluation', 'competence', 'level'));
        $evaluationkey = new XMLDBKey('evaluationfk');
        $evaluationkey->setAttributes(XMLDB_KEY_FOREIGN, array('evaluation'), 'artefact_epos_evaluation', array('artefact'));
        $competencekey = new XMLDBKey('competencefk');
        $competencekey->setAttributes(XMLDB_KEY_FOREIGN, array('competence'), 'artefact_epos_competence', array('id'));
        $levelkey = new XMLDBKey('levelfk');
        $levelkey->setAttributes(XMLDB_KEY_FOREIGN, array('level'), 'artefact_epos_level', array('id'));
        $competenceleveltable->setFields(array($evaluationfield, $competencefield, $levelfield, $valuefield));
        $competenceleveltable->setKeys(array($primarykey, $evaluationkey, $competencekey, $levelkey));
        create_table($competenceleveltable);

        $descriptortable = new XMLDBTable('artefact_epos_descriptor');
        $descriptorsetfield = new XMLDBField('descriptorset');
        $descriptorsetfield->setAttributes(XMLDB_TYPE_INTEGER, 10, true, false);
        change_field_type($descriptortable, $levelfield);
        change_field_type($descriptortable, $descriptorsetfield);
        $descriptorsetkey = new XMLDBKey('descriptorsetfk');
        $descriptorsetkey->setAttributes(XMLDB_KEY_FOREIGN, array('descriptorset'), 'artefact_epos_descriptorset', array('id'));
        add_key($descriptortable, $levelkey);
        add_key($descriptortable, $descriptorsetkey);

        // move type 1 evaluation items to evaluation_competencelevel table
        if ($data = get_records_array('artefact_epos_evaluation_item', 'type', 1)) {
            foreach ($data as $item) {
                $target_key = explode(';', $item->target_key);
                $complevel = new stdClass();
                $complevel->evaluation = $item->evaluation;
                $complevel->competence = $target_key[0];
                $complevel->level = $target_key[1];
                $complevel->value = $item->value;
                insert_record('artefact_epos_evaluation_competencelevel', $complevel);

                // insert missing descriptors in evaluation_item table
                $evaluationdata = get_record('artefact_epos_evaluation', 'artefact', $item->evaluation);
                $select = 'descriptorset = ? AND competence = ? AND level = ?';
                $values = array($evaluationdata->descriptorset, $target_key[0], $target_key[1]);
                if ($descriptors = get_records_select_array('artefact_epos_descriptor', $select, $values)) {
                    foreach ($descriptors as $descriptor) {
                        $descriptoritem = new stdClass();
                        $descriptoritem->evaluation = $item->evaluation;
                        $descriptoritem->descriptor = $descriptor->id;
                        $descriptoritem->value = $item->value;
                        insert_record('artefact_epos_evaluation_item', $descriptoritem);
                    }
                }
            }
        }
        delete_records('artefact_epos_evaluation_item', 'type', 1);

        // move 'customcompetence' artefacts to competence table
        $artefactcompetencemap = array();
        $artefactdescriptormap = array();
        if ($data = get_records_array('artefact', 'artefacttype', 'customcompetence')) {
            foreach ($data as $customcompetence) {
                $competence = new stdClass();
                $competence->name = $customcompetence->title;
                $competenceid = insert_record('artefact_epos_competence', $competence, 'id', true);
                $artefactcompetencemap[$customcompetence->id] = $competenceid;
            }
        }
        // move 'customgoal' artefacts to descriptor, update evaluation_item
        if ($data = get_records_array('artefact', 'artefacttype', 'customgoal')) {
            foreach ($data as $customgoal) {
                $descriptor = new stdClass();
                $descriptor->name = $customgoal->title;
                $descriptor->competence = $artefactcompetencemap[$customgoal->parent];
                $descriptor->goal_available = 1;
                $descriptorid = insert_record('artefact_epos_descriptor', $descriptor, 'id', true);
                $artefactdescriptormap[$customgoal->id] = $descriptorid;
            }
        }
        foreach ($artefactdescriptormap as $artefact => $id) {
            $item = new stdClass();
            $item->descriptor = $id;
            $where = array('target_key' => "$artefact");
            if (update_record('artefact_epos_evaluation_item', $item, $where)) {
                delete_records('artefact', 'id', $artefact);
            }
        }
        delete_records('artefact', 'artefacttype', 'customcompetence');

        // tidy up artefact_epos_evaluation_item
        $evaluationitemtable = new XMLDBTable('artefact_epos_evaluation_item');
        $typefield = new XMLDBField('type');
        $targetkeyfield = new XMLDBField('target_key');
        drop_field($evaluationitemtable, $typefield);
        drop_field($evaluationitemtable, $targetkeyfield);
    }

    if ($oldversion < 2016022700) {
        // remove NOT NULL constraints (for LEAP import)
        $descriptorsettable = new XMLDBTable('artefact_epos_descriptorset');
        $filefield = new XMLDBField('file');
        $filefield->setAttributes(XMLDB_TYPE_TEXT, null, null, false);
        $evaluationtable = new XMLDBTable('artefact_epos_evaluation');
        $evaluatorfield = new XMLDBField('evaluator');
        $evaluatorfield->setAttributes(XMLDB_TYPE_INTEGER, 10, null, false);
        change_field_type($descriptorsettable, $filefield);
        change_field_type($evaluationtable, $evaluatorfield);
    }

    return true;
}
