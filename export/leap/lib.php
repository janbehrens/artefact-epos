<?php
/**
 *
 * @package    mahara
 * @subpackage artefact-epos-export-leap
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL version 3 or later
 * @copyright  For copyright information on Mahara, please see the README file distributed with this software.
 *
 */

class LeapExportEpos extends LeapExportArtefactPlugin {

    private $descriptorsets = array();

    public function __construct(PluginExportLeap $exporter, array $artefacts) {
        parent::__construct($exporter, $artefacts);
        foreach ($this->artefacts as $a) {
            $did = $a->get('descriptorset');
            if (!array_key_exists($did, $this->descriptorsets)) {
                $this->descriptorsets[$did] = new Descriptorset($did);
            }
        }
    }

    /**
     * Build entries for descriptorsets and self-evaluation artefacts
     */
    public function get_export_xml() {
        $xml = '';
        foreach ($this->descriptorsets as $d) {
            $element = new LeapExportElementDescriptorset($d, $this->exporter);
            $xml .= $element->get_export_xml();
        }
        foreach ($this->artefacts as $a) {
            $element = new LeapExportElementEvaluation($a, $this->exporter);
            $element->add_descriptorset_link();
            $element->assign_smarty_vars();
            $xml .= $element->get_export_xml();
        }
        return $xml;
    }
}

class LeapExportElementDescriptorset extends LeapExportElement {

    private $descriptorset;

    public function __construct(Descriptorset $descriptorset, PluginExportLeap $exporter) {
        parent::__construct(null, $exporter);
        $this->descriptorset = $descriptorset;
        $this->assign_smarty_vars();
    }

    public function assign_smarty_vars() {
        $this->smarty->assign('artefacttype', 'epos');
        $this->smarty->assign('artefactplugin', 'epos');
        $this->smarty->assign('title', $this->descriptorset->name);
        $this->smarty->assign('id', 'portfolio:descriptorset' . $this->descriptorset->id);
        $this->smarty->assign('leaptype', $this->get_leap_type());
        $this->smarty->assign('content', $this->descriptorset->export_json());
    }

    public function get_leap_type() {
        return 'descriptorset';
    }
}

class LeapExportElementEvaluation extends LeapExportElement {

    /**
     * Override title
     * @see LeapExportElement::assign_smarty_vars()
     */
    public function assign_smarty_vars() {
        parent::assign_smarty_vars();
        $this->smarty->assign('title', $this->artefact->display_title());
    }

    public function get_leap_type() {
        return 'evaluation';
    }

    public function get_content_type() {
        return 'text';
    }

    public function get_content() {
        $evaluation = new ArtefactTypeEvaluation($this->artefact->get('id'));
        return $evaluation->export_json();
    }

    /**
     * Add a link to the descriptorset entry this evaluation uses
     * (the LEAP relationship type is arbitrary)
     */
    public function add_descriptorset_link() {
        $this->add_generic_link('descriptorset' . $this->artefact->get('descriptorset'), 'supported_by');
    }
}
