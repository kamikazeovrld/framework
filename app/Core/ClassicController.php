<?php
/**
 * ClassicController - Base Class for all Classic Controllers.
 *
 * @author Virgil-Adrian Teaca - virgil@@giulianaeassociati.com
 * @version 3.0
 * @date December 18th, 2015
 */

namespace App\Core;

use Smvc\Core\View;
use Smvc\Core\Controller;

/**
 * Simple themed controller showing the typical usage of the Flight Control method.
 */
class ClassicController extends Controller
{
    protected $layout = 'default';

    // Store the Controller's variables.
    protected $data = array();

    protected $autoRender = true;
    protected $useLayout  = false;

    /**
     * Call the parent construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function beforeFlight()
    {
        // Do some processing there and stop the Flight, if is the case.
        // The available information on this method are:
        // className, called method and parameters; optionally, the module name

        // Leave to the parent's method the Flight decisions.
        return parent::beforeFlight();
    }

    public function afterFlight($result)
    {
        if(($result === false) || ! $this->autoRender) {
            // Errors in called Method or isn't wanted the auto-Rendering; stop the Flight.
            return false;
        }

        if(($result === true) || is_null($result)) {
            $data =& $this->data();

            $content = View::render($this->method(), $data, false, true);

            if($this->useLayout) {
                View::renderLayout($this->layout(), $content, $data);
            }
            else {
                View::sendHeaders();

                echo $content;
            }

            // The current Page was rendered there; stop the Flight.
            return false;
        }

        // Leave to the parent's method the Flight decisions.
        return parent::afterFlight($result);
    }

    public function autoRender($value = null)
    {
        if(is_null($value)) {
            return $this->autoRender;
        }

        $this->autoRender = $value;
    }

    public function useLayout($value = null)
    {
        if(is_null($value)) {
            return $this->useLayout;
        }

        $this->useLayout = $value;
    }

    public function data($name = null)
    {
        if(is_null($name)) {
            return $this->data;
        }
        else if(isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    public function set($name, $value = null)
    {
        if (is_array($name)) {
            if (is_array($value)) {
                $data = array_combine($name, $value);
            }
            else {
                $data = $name;
            }
        }
        else {
            $data = array($name => $value);
        }

        $this->data = $data + $this->data;
    }

    public function title($title)
    {
        $data = array('title' => $title);

        $this->data = $data + $this->data;

        // Auto-activate the Rendering on Layout.
        $this->useLayout = true;
    }

}
