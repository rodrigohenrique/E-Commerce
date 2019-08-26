<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {

    const SESSION = 'User';

    public static function login(string $login="", string $password="") {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", [
            ':LOGIN' => $login,
        ]);
        if (empty($results)) {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
        $data = $results[0];
        if (password_verify($password, $data['despassword']) === true) {
            $user = new User();
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        } else{
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }

    public static function logout() {
        if (isset($_SESSION[User::SESSION])) $_SESSION[User::SESSION] = null;
    }

    public static function isAdminLoggedIn(bool $inadmin=true) : bool {
        return isset($_SESSION[User::SESSION])
            && !empty($_SESSION[User::SESSION])
            && ((bool) $_SESSION[User::SESSION]['inadmin'] === $inadmin);
    }

}