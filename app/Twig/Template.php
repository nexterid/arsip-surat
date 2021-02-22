<?php

/**
 * Twig for Codeigniter 4
 *
 * @package   TwigCodeigniter4
 * @author    Khai Phan
 * @copyright Copyright (c) 2020, Khai Phan
 * @license   MIT
 * @link      https://github.com/khaiphan9x/twig-template-engine-for-codeigniter4
 */
 
namespace App\Twig;

class Template
{
	private $twig;
	private $ext = '.twig';
	
	public function __construct() {
		$loader = new \Twig\Loader\FilesystemLoader(APPPATH.'Views');
		$twig = new \Twig\Environment($loader, [
			'debug' => true,
			'cache' => WRITEPATH.'cache',
		]);
		$twig->addExtension(new \Twig\Extension\DebugExtension);
		foreach(get_defined_functions()['user'] as $function) {
			if (!preg_match('/^twig|_twig/', $function)) {
				$twig->addFunction(new \Twig\TwigFunction($function, $function));
			}
		}
		$this->twig = $twig;
	}
	
	public function display($tpl, $vars = array()) {
		try {
			echo $this->twig->render($tpl.$this->ext, $vars);
		} catch (\Twig\Error\SyntaxError $e) {
			echo 'Syntax Error: ' . $e->getMessage();
		} catch (\Twig\Error\RuntimeError $e) {
			echo 'Runtime Error: ' . $e->getMessage();
		} catch (\Twig\Error\LoaderError $e) {
			echo 'Loader Error: ' . $e->getMessage();
		} catch (\Twig\Error\Error $e) {
			echo 'Twig Error: ' . $e->getMessage();
		} catch (\Twig\Sandbox\SecurityError $e) {
			echo 'Sandbox Security Error: ' . $e->getMessage();
		}
	}
	
	public function checkSyntax($source, $identifier = '') {
		try {
			$this->twig->parse($this->twig->tokenize(new \Twig\Source($source, $identifier)));
		} catch (\Twig\Error\SyntaxError $e) {
			echo 'Syntax Error: ' . $e->getMessage();
		} catch (\Twig\Error\RuntimeError $e) {
			echo 'Runtime Error: ' . $e->getMessage();
		} catch (\Twig\Error\LoaderError $e) {
			echo 'Loader Error: ' . $e->getMessage();
		} catch (\Twig\Error\Error $e) {
			echo 'Twig Error: ' . $e->getMessage();
		} catch (\Twig\Sandbox\SecurityError $e) {
			echo 'Sandbox Security Error: ' . $e->getMessage();
		}
	}
	
	function addExtension($extension) {
		return $this->twig->addExtension($extension);
	}
	
	function addGlobal($name, $value) {
		return $this->twig->addGlobal($name, $value);
	}
	
	function addFilter($name, $callable) {
		return $this->twig->addFilter(new \Twig\TwigFilter($name, $callable));
	}
	
	function addFunction($name, $callable) {
		return $this->twig->addFunction(new \Twig\TwigFunction($name, $callable));
	}
}
