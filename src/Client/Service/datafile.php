<?php

class Datafile {
    private $dir;

    function __construct(String $dir)
    {
        $this->dir = $dir;
    }
    
    /**
     * Retourne une liste de nom de fichier depuis un répertoire
     */
    function findAll(): array
    {
        if (!is_dir($this->dir)) exit('Invalid diretory path');

        $files = [];

        foreach (scandir($this->dir) as $file) {
            if ('.' === $file) continue;
            if ('..' === $file) continue;

            $files[] = $file;
          }

          return $files;
    }

    /**
     * Retourne le nom d'un survey depuis son id
     */
    function findNameById($files, $id): String
    {
        foreach ($files as $file) {
            $json = file_get_contents($this->dir."/".$file);
            $json_data = json_decode($json, true);

            if ($json_data["survey"]["code"] == $id) return $json_data["survey"]["name"];
        }

        return null;
    }

    /**
     * Retourne un tableau de json selon un id
     */
    function findById($files, $id): array
    {
        $results = [];

        foreach ($files as $file) {
            $json = file_get_contents($this->dir."/".$file);
            $json_data = json_decode($json, true);
    
            if ($json_data["survey"]["code"] == $id) $results[] = $json;    
        }
        
        return $results;
    }
}

?>