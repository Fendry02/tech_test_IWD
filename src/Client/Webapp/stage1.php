<?php

require_once 'src/Client/Model/survey.php';
require_once 'src/Client/Service/datafile.php';

$stage1 = $app['controllers_factory'];
$stage1->get('/',  function() use($app) {
  $path = dirname($_SERVER['DOCUMENT_ROOT'])."/data";
  $codes = array();
  $surveys = array();
  
  $db = new Datafile($path);
  $files = $db->findAll();

  foreach ($files as $file) {
    $json = file_get_contents($path.'/'.$file);  			
		$json_data = json_decode($json, true);

		if (!in_array($json_data["survey"]["code"], $codes)) {
		  array_push($codes, $json_data["survey"]["code"]);

			$surveys[] = new Survey($json_data["survey"]["name"], $json_data["survey"]["code"]);
		}        
  }
    
  return $app->json($surveys);
}); 

return $stage1;

?>