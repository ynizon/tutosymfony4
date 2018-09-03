<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('myrandom', array($this, 'myrandomFilter')),
        );
    }

	//Valeur par defaut a expliquer
	//LIste des tags: https://symfony.com/fr/doc/current/reference/dic_tags.html
    public function myrandomFilter($number, $suffix = ".")
    {       
        return "-".uniqid($number).$suffix;
    }
}