<?php
/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * @package Plugins
 * @subpackage google_translate
 *
 * @author Anonymous
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

class GoogleTranslateController extends PluginController {

    public function __construct() {
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/google_translate/views/sidebar'));
    }

    public function index() {
        $this->documentation();
    }

    public function documentation() {
        $this->display('google_translate/views/documentation');
    }
}