<?php
/**
 * Application class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * Engine of application
 */
class Application
{
    /**
     * Write data in log file
     *
     * @static
     * @param string $message data that will be written in log file
     */
    static public function log($message)
    {
        $date = date('Y-m-d H:i:s');
        file_put_contents(WWW_DIR . Registry::get('log_file'), $date . ' > ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
        self::setHttpError();
    }
    /**
     * Set http response
     *
     * @static
     */
    static public function setHttpError()
    {
        ob_end_clean();
        header('HTTP/1.1 500 Internal Server Error');
    }
    /**
     * Handle critical errors, that transmit in this method by register_shutdown_function
     *
     * @static
     */
    static public function fatalErrorHandler()
    {
        if ($e = error_get_last()) {
            $message = sprintf('Fatal error %s : %s in %s:%s', $e['type'], $e['message'], $e['file'], $e['line']);
            self::log($message);
        }
    }
    /**
     * Handle regular errors, that transmit in this method by set_error_handler
     *
     * @static
     * @param int $errno specify error number
     * @param string $errstr specify error message
     * @param string $errfile specify file where error appears
     * @param string $errline specify line of file where error appears
     */
    static public function regularErrorHandler($errno, $errstr, $errfile, $errline)
    {
        $message = sprintf('Regular error %s : %s in %s:%s', $errno, $errstr, $errfile, $errline);
        self::log($message);
        exit;
    }
    /**
     * Handle uncaught exceptions, that transmit in this method by root try-catch block
     *
     * @static
     * @param \Exception $e instance of exception
     */
    static public function uncaughtExceptionHandler(\Exception $e)
    {
        $message  = sprintf('Uncaught exception %s : %s in %s:%s', $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        $message .= PHP_EOL . $e->getTraceAsString();
        self::log($message);
        exit;
    }
    /**
     * Autoload method, that try to include file of requested class
     *
     * @static
     * @param string $className name of requested class
     */
    static public function autoload($className)
    {
        $path = str_replace('\\', '/', $className) . '.php';
        require($path);
    }
    /**
     * Constructor
     *
     * @param array $config contains global application preferences
     */
    public function __construct($config)
    {
        try {
            ob_start();
            $this->init();
            Registry::set($config);
            $this->route();
        } catch (\Exception $e) {
            self::uncaughtExceptionHandler($e);
        }
    }
    /**
     * Init function registers different handlers
     */
    public function init()
    {
        error_reporting(E_ALL | E_STRICT);
        register_shutdown_function(array($this, 'fatalErrorHandler'));
        set_error_handler(array($this, 'regularErrorHandler'));
        spl_autoload_register(array($this, 'autoload'));
    }
    /**
     * Route function disassembles user request for the parts and gets controller parameters
     *
     * @return mixed
     * @throws \Exception
     */
    private function route()
    {
        $base = substr($_SERVER['PHP_SELF'], 0, -9); // 10 = strlen(index.php)
        Registry::set(array('site_path' => $base));
        $uri = substr($_SERVER['REQUEST_URI'], strlen($base));
        $pieces = explode('/', trim($uri, '/'), 2);

        $controller = empty($pieces[0]) ? Registry::get('index_controller') : $pieces[0];
        $controller = 'Core\\' . ucfirst($controller) . 'Controller';
        $params     = empty($pieces[1]) ? '' : $pieces[1];

        if (class_exists($controller)) {
            return new $controller($params);
        } else {
            throw new \Exception('Route error');
        }
    }
}