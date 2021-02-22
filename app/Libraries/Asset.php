<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Codeigniter asset versioning installer
 *
 * @author     Roland Oduberu <https://github.com/roliod>
 * @license    MIT License
 * @copyright  2018 Roland Oduberu
 * @link       https://github.com/roliod/codeigniter-asset-versioning/releases
 */

class Asset {
    
    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    public function version_url($path = '')
    {
        $base_url = $this->_CI->config->item('base_url');
        $version = filemtime(FCPATH . $path);

        return $base_url . '/' . $path . '?v=' . $version;
    }
}
