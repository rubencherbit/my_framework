<?php
namespace cherbi_r 
{
	use Twig_Autoloader;
	use Twig_Loader_Filesystem;

	class Core
	{
		protected $page;
		protected $action;
		static public $param;
		
		static public function run()
		{
			try {
				require_once '..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Twig'.DIRECTORY_SEPARATOR.'Autoloader.php';
				self::registerAutoload();
				self::loadConfig();
				Twig_Autoloader::register();
				$core = new self;
				$core->loadpage();
				$action = $core->action;
				if (file_exists('..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$core->page.'.php')) {
					$class = "app\controllers\\".$core->page;
					$controller = new $class();
					if (method_exists($controller, $action)) {
						$controller->$action();
					} else {
						$action = df_action;
						$controller->$action();
					}
				} else {
					echo '404';
					header("HTTP/1.1 404 Not Found");
				}
			} catch (\Exception $e) {
				if ($e instanceof NotFoundException) {
					echo '404';
					header("HTTP/1.1 404 Not Found");
				} else {
					echo '500';
					header("HTTP/1.1 500 Internal Server Error");
					// die('Error: ' . $e->getMessage());

				}
			}
		}

		static public function loadConfig()
		{
			$config = parse_ini_file('..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config.ini');
			foreach ($config as $key => $value) {
				define($key, $value);
			}
		}

		static public function registerAutoload()
		{
			spl_autoload_register( function ($class) {
				$class = ltrim($class, '\\');
				$fileName  = '';
				$namespace = '';
				if ($lastNsPos = strrpos($class, '\\')) {
					$namespace = substr($class, 0, $lastNsPos);
					$class = substr($class, $lastNsPos + 1);
					$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
				}
				$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
				if (file_exists('..'.DIRECTORY_SEPARATOR.$fileName)) {
					include_once '..'.DIRECTORY_SEPARATOR.$fileName;
				}
				if (file_exists('..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.$fileName)) {
					include_once '..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.$fileName;
				}
				$class =  str_replace('Controller', '', $class);
				if (file_exists('..'.DIRECTORY_SEPARATOR.$fileName)) {
					include_once '..'.DIRECTORY_SEPARATOR.$fileName;
				}
				// $class = str_replace('\\', '/',$class);
				// if (file_exists("../".$class.'.php')) {
				// 	include_once "../".$class.'.php';
				// }
				// if (file_exists('../lib/'.$class.'.php')) {
				// 	include_once '../lib/'.$class.'.php';
				// }
				// $class =  str_replace('Controller', '', $class);
				// if (file_exists("../".$class.'.php')) {
				// 	include_once "../".$class.'.php';
				// }
			});
		}

		public function loadpage()
		{
			if (false !== Tools::getParam('page') && !empty(Tools::getParam('page'))) {
				if(substr(Tools::getParam('page')-1, -1) !== "/")
					$_GET['page'] .= "/";
				if (!empty(strrchr(Tools::getParam('page'), '/'))) {
					self::$param = explode('/',Tools::getParam('page'));
					for ($i = 0; $i < count(self::$param);$i++) {
						if (isset(self::$param[$i + 1]) && $i % 2 === 0)
						{
							self::$param[self::$param[$i]] = self::$param[$i + 1];
						}
					}
					$this->page = ucfirst(strtolower(Tools::getParam('0'))).'Controller';
					$this->action = ucfirst(strtolower(Tools::getParam('1'))).'Action';

				} else {
					$this->page = ucfirst(strtolower(Tools::getParam('0')))."Controller";
					$this->action = "IndexAction";
				}
			} else {
				$this->page = df_controller;
				$this->action = df_action;
			}
		}
	}
}