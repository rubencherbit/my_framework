<?php
namespace app\controllers
{
	use app\models\UserTable;
	use cherbi_r\Controller;

	class IndexController extends Controller
	{
		public function indexAction()
		{
			// throw new \Exception("Error Processing Request");
			echo basename(__FILE__);
			$u = new UserTable();
			$array = $u->findOne('1 = ', '1');
			$this->render(self::class.":"."index", $array);
			/*
			Pour les exercices précedent
			*/
			// $this->render(str_replace('\\', '',strrchr(self::class, '\\')).":"."index.html", array("foo" => "bar", "baz" => 42, "c" => 3));
		}
	}
}