<?php
/**
 * @todo Create default Zend Routes
 */
$front = Zend_Controller_Front::getInstance();
$router = $front->getRouter();

// ...'Read' controller routes
$route = new Zend_Controller_Router_Route(
	'a/:id/:title',
	array(
		'controller' => 'read',
		'action' => 'article',
		'module' => 'default'
	)
);
$router->addRoute('indexReadArticle', $route);
//
//$route = new Zend_Controller_Router_Route(
//	'a/:id/:title',
//	array(
//		'controller' => 'read',
//		'action' => 'article',
//		'module' => 'default'
//	)
//);
//$router->addRoute('indexArticleRead', $route);