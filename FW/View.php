<?php
/**
 * View class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * View class is the one of three MVC pattern components
 */
class View
{
    /**
     * @var array contains variables that can be used in templates
     */
    private $_vars = array();
    /**
     * Parse template file
     *
     * @param string $partName name of template file
     * @return string parsed content
     * @throws \Exception
     */
    private function _getPart($partName)
    {
        extract($this->_vars);
        $partFile = WWW_DIR . Registry::get('view_dir') . '/' . $partName . '.php';

        if (file_exists($partFile)) {
            include($partFile);
        } else {
            throw new \Exception(__FILE__ . ' : Part file not found' . $partName);
        }

        return ob_get_clean();
    }
    /**
     * Add variable that will can be used in templates
     *
     * @param string $name name of variable
     * @param string $value value of variable
     */
    public function assign($name, $value)
    {
        $this->_vars[$name] = $value;
    }
    /**
     * Parse layout file
     *
     * @param string $layout name of layout file
     * @param array $parts array of parts that will be parsed by _getPart method
     * @throws \Exception
     */
    public function render($layout, $parts)
    {
        foreach ($parts as $varName => $partName) {
            $$varName = $this->_getPart($partName);
        }

        extract($this->_vars);

        $template = WWW_DIR . Registry::get('view_dir') . '/_' . $layout . '.php';

        if (file_exists($template)) {
            include($template);
        } else {
            throw new \Exception(__FILE__ . ' : Layout not found ' . $template);
        }
    }
}