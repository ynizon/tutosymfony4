<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\TranslatorInterface;
use App\Controller\MyController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;

class ConsoleController extends MyController
{
	
    public function index(Request $request): Response
    {		
		//Uniquement en dev et pas en prod !!!
		if ($_SERVER['APP_ENV'] == "dev"){
			$_SERVER['argv'] = array("bin/console");
			
			$input = new ArgvInput(); 
			$env = $input->getParameterOption(['--env', '-e'], $_SERVER['APP_ENV'] ?? 'dev', true);
			$debug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $env)) && !$input->hasParameterOption('--no-debug', true);
			$kernel = new Kernel($env, $debug);
			$application = new Application($kernel);
			
			$allcommands=$application->all();
						
			$output = "";
			$execute = trim($request->query->get("execute"));
			
			if ($execute != ""){
				//On execute la commande
				$output = shell_exec("php ../bin/console ".$execute);
				//$application->run($input); echo "xx";
			}		
			
			$commands = array();
			foreach ($allcommands as $command){
				$mycommand = array();
				$mycommand["name"] = $command->getName();
				$mycommand["description"] = $command->getDescription();
				$commands[] = $mycommand;
			}
			
			return $this->render('console/index.html.twig',["commands"=>$commands,"output"=>$output,"execute"=>$execute]);
		}
    }	
}