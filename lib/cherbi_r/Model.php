<?php
namespace cherbi_r
{
    use PDO;
    
    abstract class Model
    {
        private $host = db_host;
        private $port = db_port;
        private $db = db_name;
        private $user = db_user;
        private $socket = db_socket;
        private $password = db_password;
        protected static $pdo;

        public function __construct()
        {
            if (null === self::$pdo) {
                try {
                    if ($this->socket !== "")
                        self::$pdo = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db.';unix_socket='.$this->socket, $this->user, $this->password);
                    else
                        self::$pdo = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->db, $this->user, $this->password);

                } catch (Exception $e) {
                    // die('Error: ' . $e->getMessage());
                }
            }
            return self::$pdo;
        }
        public function get_columns()
        {
            $req = self::$pdo->prepare("SHOW COLUMNS FROM $this->table");
            $req->execute();
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        public function insert()
        {

        }
        public function findOne($where, $value)
        {
            $req = self::$pdo->prepare("SELECT * FROM `$this->table` WHERE ".$where." :value");
            $req->bindParam(':value', $value);
            $req->execute();
            $res = $req->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        public function delete($where, $value)
        {
            $req = self::$pdo->prepare("DELETE FROM `$this->table` WHERE ".$where." :value");
            $req->bindParam(':value', $value);
            $req->execute();

        }
        public function listAll()
        {
            $req = self::$pdo->prepare("SELECT * FROM `$this->table`");
            $req->execute();
            $res = $req->fetchall(PDO::FETCH_ASSOC);
            return $res;
        }
        public function getHost()
        {
            return $this->host;
        }

        public function setHost($host)
        {
            $this->host = $host;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function setUser($user)
        {
            $this->user = $user;
        }

        public function getPort()
        {
            return $this->port;
        }

        public function setPort($port)
        {
            $this->port = $port;
        }

        public function getDb()
        {
            return $this->db;
        }

        public function setDb($db)
        {
            $this->db = $db;
        }

        public function getSocket()
        {
            return $this->socket;
        }

        public function setSocket($socket)
        {
            $this->socket = $socket;
        }
    }
}