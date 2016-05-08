<?php
namespace app\controllers
{
	use app\models\UserTable;
	use cherbi_r\Controller;
	use cherbi_r\Tools;

	class UserController extends Controller
	{
		public function indexAction()
		{
			$user = new UserTable();
			$array = $user->listAll();
			$this->render(self::class.":"."index", array('users' => $array, 'url' => url));
		}
		public function deleteAction()
		{
			$user = new UserTable();
			if(false !== Tools::getParam('id'))
				$user->delete('id = ', Tools::getParam('id'));
			header('Location: /'.url.'/user/');
		}
		public function updateAction()
		{
			$user = new UserTable();
			if (Tools::getParam('login') && Tools::getParam('id')) {
				$user->updateuser(Tools::getParam("firstname"), Tools::getParam("lastname"), Tools::getParam("login"), Tools::getParam("email"),Tools::getParam('id'));
				header('Location: /'.url.'/user/read/'.Tools::getParam('id'));
			} else if (false !== Tools::getParam('id')){
				$array = $user->findOne('id =', Tools::getParam('id'));
				if (!empty($array)) {
					$this->render(self::class.":"."update", array('result' => $array, 'url' => url));
				} else {
					header('Location: /'.url.'/user/');
				}
			} else {
				header('Location: /'.url.'/user/');
			}

		}
		public function readAction()
		{
			$user = new UserTable();
			if (false !== Tools::getParam('id')){
				$array = $user->findOne('id =', Tools::getParam('id'));
				if (!empty($array)) {
					$this->render(self::class.":"."read", array('result' => $array, 'url' => url));
				} else {
					header('Location: /'.url.'/user/');
				}
			} else {
				header('Location: /'.url.'/user/');
			}

		}
		public function CreateAction()
		{
			$user = new UserTable();
			if (Tools::getParam('login')) {
				$user->insertuser(Tools::getParam("firstname"), Tools::getParam("lastname"), Tools::getParam("login"), Tools::getParam("email"));
				header('Location: /'.url.'/user/');
			} else {
				$this->render(self::class.":"."create", array('url' => url));
			}
		}
	}
}