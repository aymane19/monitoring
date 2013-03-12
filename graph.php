<?php

  function printr($var)
  {
    $output = print_r($var, true);
    $output = str_replace("\n", "<br>", $output);
    $output = str_replace(' ', '&nbsp;', $output);
    echo "<div style='font-family:courier;'>$output</div>\r\n";
  }
 
  include('class.graphite.php');
  $graph = new Graphite("10.248.4.145", 80, "render");  
  
  // We need to be able to process the incomming data
  $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : false;
  $render = (isset($_REQUEST['render'])) ? $_REQUEST['render'] : false;
  
  // This array is used to managet the target and the Naming convention
  $renders = array('roundtrip'=>array('target'=>array("Roundtrip.*.*.Response"),
				      'params'=>array("from"=>"-20minutes", "until"=>"-1minute"),
				      'name-format'=>array(3)),
		   
		  'web'=>array('target'=>array("averageSeries(Uptime.*.web.Response)",
					      "averageSeries(Uptime.*.http.Response)",
					      "averageSeries(Uptime.*.xml.Response)",
					      "averageSeries(Uptime.*.soap.Response)",
					      "averageSeries(Uptime.*.smpp.Response)",
					      "averageSeries(Uptime.*.smtp.Response)",
					      "averageSeries(Uptime.*.ftp.Response)",
					      "averageSeries(Uptime.*.connect.Response)",
					      "averageSeries(Uptime.*.com.Response)"),
				      'params'=>array("from"=>"-20minutes"),
				      'name-format'=>array(3)),
		   
		  'http'=>array('target'=>array("Uptime.*.http.Response"),
				      'params'=>array("from"=>"-20minutes", "until"=>"-1minute"),
				      'name-format'=>array(2,3)),
		
		  'xml'=>array('target'=>array("Uptime.*.xml.Response"),
				      'params'=>array("from"=>"-20minutes", "until"=>"-1minute"),
				      'name-format'=>array(2,3)),
		  
		  'smpp'=>array('target'=>array("Uptime.*.smpp.Response"),
				      'params'=>array("from"=>"-20minutes", "until"=>"-1minute"),
				      'name-format'=>array(2,3)),		  
  );
  
  // Check if the requirements are met?
  if ( ($action) && ($render) )
  {
    // Set the targets and params
    $graph->target($renders[$render]['target']);
    $graph->params($renders[$render]['params']);
    
    // And echo the informations
    echo $graph->export($graph->process(false),
			$action,
			$renders[$render]['name-format']
		    );
  }
  
?>