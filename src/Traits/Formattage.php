<?php
namespace App\Traits;
trait Formattage
{
  public function titre($s)
  {
    return '--> '.$s.' <--';
  }
}