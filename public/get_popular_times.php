<?php
    header('Content-Type: application/json');

    $popular_times = array();

    
    if( !isset($_POST['arguments']) ) { 
      $popular_times['error'] = 'No function arguments!'; 
    }

    if( !isset($popular_times['error']) ) {

               if( !is_array($_POST['arguments']) || count($_POST['arguments']) < 4 ) {
                   $popular_times['error'] = 'Error in arguments!';
               }
               else {
                   $popular_times['result'] = exec("python python/scrape.py ".floatval($_POST['arguments'][0])." ".floatval($_POST['arguments'][1])." ".floatval($_POST['arguments'][2])." ".floatval($_POST['arguments'][3]));


               }

    }
    echo json_encode($popular_times);




?>

 
