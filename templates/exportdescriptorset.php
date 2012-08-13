<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2010 Catalyst IT Ltd and others; see:
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
 * @author     Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

define('INTERNAL', 1);

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
require_once('file.php');

$file = param_variable('file');
$dataroot = realpath(get_config('dataroot'));
$path = "$dataroot/artefact/epos/descriptorsets/$file";

$options = array('forcedownload' => true);
serve_file($path, $file, 'application/xml', $options);

?>
