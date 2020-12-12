<?php


namespace App\Console\Commands\Support\Model;

/**
 * Class StubResolver
 * @package App\Console\Commands\Support\Model
 */
class StubResolver
{
   function getContent($type,$field){
       // Leggi lo stub relativo al al nome  del campo se esiste.
       if($this->stubExist($field)){
            return file_get_contents(__DIR__ . "/stubs/fieldspecs/{$field}.stub");
       }
       // Leggi lo stub relativo al tipo corretto.
       return file_get_contents(__DIR__ . "/stubs/fieldspecs/{$type}.stub");
   }

   function stubExist($path){
       if (file_exists(__DIR__ . "/stubs/fieldspecs/{$path}.stub")) return true;
       return false;
   }
}
