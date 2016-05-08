<?php
namespace app\models
{
	use cherbi_r\Model;
	class UserTable extends Model
	{
		protected $table = 'users';

		public function updateuser($firstname, $lastname, $login, $email, $bind)
		{
			$req = self::$pdo->prepare("UPDATE `$this->table` SET `firstname` = :firstname, `lastname` = :lastname, `login` = :login, `email` = :email WHERE `id` = :bind");
			$req->bindParam(':firstname', $firstname);
			$req->bindParam(':lastname', $lastname);
			$req->bindParam(':login', $login);
			$req->bindParam(':email', $email);
			$req->bindParam(':bind', $bind);
			$req->execute();
		}
		public function insertuser($firstname, $lastname, $login, $email)
		{
			$req = self::$pdo->prepare("INSERT INTO `$this->table` (`firstname`, `lastname`, `login`, `email`) VALUES(:firstname, :lastname, :login, :email)");
			$req->bindParam(':firstname', $firstname);
			$req->bindParam(':lastname', $lastname);
			$req->bindParam(':login', $login);
			$req->bindParam(':email', $email);
			$req->execute();
		}
	}
}