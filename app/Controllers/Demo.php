<?php
namespace App\Controllers;

use Smvc\Core\View;
use Smvc\Core\Controller;

/*
*
* Demo controller
*/
class Demo extends Controller
{

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Define Index method
     */
    public function index()
    {
        echo 'hello';
    }

    public function test($param1 = '', $param2 = '', $param3 = '', $param4 = '')
    {
        $params = array(
            'param1' => $param1,
            'param2' => $param2,
            'param3' => $param3,
            'param4' => $param4
        );

        echo '<pre>'.var_export($params, true).'</pre>';
    }

    public function catchAll($str)
    {
        echo htmlspecialchars($str, ENT_COMPAT, 'ISO-8859-1', true);
    }
}
