<?php
namespace cherbi_r
{
	use Twig_Loader_Filesystem;
	use Twig_Environment;

	abstract class Controller
	{
		public function render($view, $var = array())
		{
			$view = str_replace('Controller', '',str_replace('\\', '',strrchr($view, '\\')));
			$loader = new Twig_Loader_Filesystem('..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
			$twig = new Twig_Environment($loader, array());
			$view = str_replace(':', '/', $view).'.'.views_extension;
			echo $twig->render($view, $var);
			
			/*
				Render without twig template engine.
			*/

			// if ($var !== null) {
			// 	ob_start();
			// 	include '../app/views/'.str_replace(':', '/', $view);
			// 	$content = ob_get_clean();
			// 	foreach ($var as $key => $value) {
			// 		$content = str_replace("{{ ".$key." }}", $value , $content);
			// 	}
			// 	echo $content;
			// 	ob_end_flush();
			// }
			// else
			// 	include_once '../app/views/'.str_replace(':', '/', $view);
		}
	}
}