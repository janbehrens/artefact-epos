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
 * @author     Jan Behrens, Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012-2013 TZI / Universität Bremen
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
        rename_table($table, 'artefact_epos_descriptorset');
        $table = new XMLDBTable('artefact_epos_checklist_item');
        $field = new XMLDBField('id');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        add_field($table, $field);
        $key = new XMLDBKey('primary');
        $key->setAttributes(XMLDB_KEY_PRIMARY, array('id'), null, null);
        add_key($table, $key);
        $field = new XMLDBField('type');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', true, XMLDB_NOTNULL, false, false, null, '0');
        add_field($table, $field);
        $field = new XMLDBField('goal');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '1', true, false, false, false, null, '0');
        change_field_type($table, $field);
        rename_table($table, 'artefact_epos_evaluation_item');
        $table = new XMLDBTable('artefact_epos_evaluation');
    	if (table_exists($table)) {
    		drop_table($table);
    	}
        $table->addFieldInfo('artefact', XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL);
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
        $table = new XMLDBTable('artefact_epos_evaluation_item');
        $field = new XMLDBField('checklist');
        rename_field($table, $field, 'evaluation_id');
        $field = new XMLDBField('evaluation');
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
    }

    if ($oldversion < 2013091601) {
        // install new artefact type "custom competence"
        insert_record('artefact_installed_type', (object) array(
            'name' => 'customcompetence',
            'plugin' => 'epos'
        ));
        // find users that have custom goals
        $usersSql = "SELECT owner AS id FROM artefact WHERE artefacttype = 'customgoal' GROUP BY owner";
        $users = get_records_sql_array($usersSql, array());
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
            $evaluations = get_records_sql_array($evaluationsSql, array($user->id));
            foreach ($evaluations as $evaluation) {
                $evaluation = new ArtefactTypeChecklist(0, $evaluation);
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

    if ($oldversion < 2013092300) {
        db_begin();
        $table = new XMLDBTable('artefact_epos_artefact_subject');
        // without primary key, the update will fail (mahara bug)
        $field = new XMLDBField('artefact');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10', true, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        change_field_type($table, $field);
        $key = new XMLDBKey('primary');
        $key->setAttributes(XMLDB_KEY_PRIMARY, array('artefact'), null, null);
        add_key($table, $key);
        $key = new XMLDBKey('artefactfk');
        $key->setAttributes(XMLDB_KEY_FOREIGN, array('artefact'), 'artefact', array('id'));
        add_key($table, $key);
        // first rename the existing sequence to something the weird mahara mechanism accepts
        try {
            // wrap this statement in its own sub transaction so it may fail
            db_begin();
            execute_sql("ALTER TABLE artefact_epos_artefact_subject_artefact_alter_column_tmp_seq1 RENAME TO artefact_epos_artefact_subject_id_seq");
            db_commit();
        }
        catch (Exception $e) {
            db_rollback();
            // don't fail, but try to rename the table anyways
        }
        // eventually do the one operation we'd like to execute
        rename_table($table, 'artefact_epos_mysubject');
        db_commit();
    }

    if ($oldversion < 2013092400) {
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

    return true;
}
