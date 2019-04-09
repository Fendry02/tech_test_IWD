<?php

require_once 'src/Client/Model/survey.php';
require_once 'src/Client/Model/question.php';
require_once 'src/Client/Service/datafile.php';

$stage2 = $app['controllers_factory'];
$stage2->get('/',  function($id) use($app) {
    // Définition de la "base de fichier"
    $db = new Datafile("C:/xampp/htdocs/backend/data");
    $files = $db->findAll();

    // Retrouve une liste de fichier selon un id sur une liste de fichier
    $filesById = $db->findById($files, $id);
    if (!$filesById) $app->abort(404, "$id does not exist.");

    $name = $db->findNameById($files, $id);

    $question = new Question($name, $id);

    foreach($filesById as $json) 
    {
        $fileById = json_decode($json, true);

        foreach($fileById["questions"] as $data) 
        {
            if ($data["type"] == "numeric") $question->addNbProducts($data["answer"]);
            if ($data["type"] == "date") $question->addDate(new DateTime($data["answer"]));
            if ($data["type"] == "qcm") {
                foreach($question->getProducts() as $key => $value)
                {
                    //array_search return false si non trouvé
                    $index = array_search($key , $data["options"]);
                    if ($data["answer"][$index]) $question->addProduct($key);
                }
            } 
        }
    }

    return $app->json($question->serialize());
}); 

return $stage2;

?>