<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\DB\Sql;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();
	$page->setTpl("index");

});

$app->get('/admin', function() {
	if (User::isAdminLoggedIn()) {
		$page = new PageAdmin([], 'views/admin');
		$page->setTpl("index");
	} else {
		header('Location: http:/localhost/e-commerce/admin/login');
		exit;
	}

});

$app->get('/admin/login', function() {
	
	if (User::isAdminLoggedIn()) {
		header('Location: http:/localhost/e-commerce/admin');
		exit;
	} else {
		$page = new PageAdmin([
			"header" => false,
			"footer" => false,
			'data' => [
				'rootAddress' => '../',
			],
		], 'views/admin');
		$page->setTpl("login");
	}

});

$app->post('/admin/login', function() {
    
	User::login($_POST['login'], $_POST['password']);
	header('Location: http:/localhost/e-commerce/admin');
	exit;

});

$app->get('/admin/logout', function () {

	if (User::isAdminLoggedIn()) User::logout();
	header('Location: http:/localhost/e-commerce/admin/login');
	exit;

});

$app->get('/admin/users', function () {

	if (User::isAdminLoggedIn()) {
		$page = new PageAdmin([
			'data' => [
				'rootAddress' => '../',
			],
		], 'views/admin');
		$page->setTpl("users");
	} else {
		header('Location: http:/localhost/e-commerce/admin/login');
		exit;
	}

});

$app->run();

 ?>