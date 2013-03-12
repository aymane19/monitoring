<?php

// This class will be used to build, render and possibly create a graph from graphite. 
class Graphite
{
  // Some variables we may need
  private $server;
  private $port;
  private $pwd;
  private $styling;
  private $dataType = array("format"=>"json");
  private $targets;
  private $params;
  private $url;
  private $dateFormat = 'Y-m-d H:i:s';//2013-03-01 09:05:00
  
  // The constructor requires the server to connect to, and the styleing of the graph
  public function __construct($server="", $port=80, $directory="", $styling=array())
  {
    // Set the default timezone
    date_default_timezone_set("Africa/Johannesburg");
    
    // Make sure the formatting is correct
    if ($server == "") die("No server provided. This should only be an IP Address or a hostname");
        
    // Make sure the port is valid
    if ( ($port == "") or (!is_numeric($port)) ) die("Invalid Port provided!");
    
    // Check the server, and if it's not available DIE
    $checkServer = $this->checkHost($server, $port);    
    if (!$checkServer) die ("Failed to connect to the host " . $server . ", please ensure that you can hit it from here");
    
    // Check the PWD and alter it should we need to
    $this->pwd = (substr($directory, -1) == '/') ? $directory : $directory . "/";
    $this->pwd = (substr($directory, 0, 1) == '/') ? $this->pwd : "/" . $this->pwd;
    $this->pwd = ($directory == "") ? "/" : $this->pwd; // Ensure it's set
    
    // Set the server up and get things going
    $this->server = $server;
    $this->port = $port;
    $this->styling = $styling;    
  }
  
  
  
  
  // Set the styling
  public function style($styling="")
  {
    // Make sure the formatting is correct
    if ( ($styling == "") or (!is_array($styling)) ) die("Invalid Styling format. Please provide it as an array('style'=>'value')");
    $this->styling = $styling;
  }
  
  
  
  
  // Set the Targets
  public function target($targets="")
  {
    // Make sure the formatting is correct
    if ( ($targets == "") or (!is_array($targets)) ) die("Invalid Target format. Please provide it as an array('target1','target2')");
    $this->targets = $targets;
  }
  
  
  
  
  // Set the Parameters
  public function params($params="")
  {
    // Make sure the formatting is correct
    if ( ($params == "") or (!is_array($params)) ) die("Invalid params format. Please provide it as an array('param','value')");
    $this->params = $params;
  }
  
  
  
  
  // Check the host and ensure that it exists
  public function checkHost($server, $port)
  {
    // Attempt to open the socket and get the response
    $fp = fsockopen($server, $port, $errno, $errstr, 30); 
    if (!$fp) {
      return false;
    } else {	
      return true;
    }
  }
  
  
  
  
  // Override the default data type
  public function type($dataType="json")
  {
    // Determine the type of data the ULR needs to create
    switch($dataType)
    {
      case "json":
	$this->dataType = array('format'=>'json');
	break;
	
      default:
	$this->dataType = array('format'=>'png');
	break;
    }
  }
  
  
  
  
  // Create the URL with the parseUrl function
  public function url()
  {   
    // Check the that params is valid
    if ( ($this->params == "") or (!is_array($this->params)) ) die("No params provided, please run class->params(paramsArray) before building");
    
    // Check the that targets are valid
    if ( ($this->targets == "") or (!is_array($this->targets)) ) die("No targets provided, please run class->target(targetArray) before building");

    //Right Lets start to create the URL
    $url = "http://" . $this->server . ":" . $this->port . $this->pwd . "?";
    
    // Build the targets
    foreach($this->targets as $val) $url .= "&target=" . $val;
    
    // Build the parameters
    foreach($this->params as $var=>$val) $url .= "&" . $var . "=" . $val;
    
    // Remember to add the datatype
    foreach($this->dataType as $var=>$val) $url .= "&" . $var . "=" . $val;
    
    // Remember to add the style as well
    if (count($this->styling) > 0)
    {
      foreach($this->styling as $var=>$val) $url .= "&" . $var . "=" . $val;
    } 

    // Set the URl
    $this->url = $url;
    return $this->url;
  }
  
  
  
  
  // Get the URL and process the information
  public function process($rawJson=true)
  {    
    // Fetch the content
    $data = file_get_contents($this->url());
    
    // Return raw Json, or an array. 
    return ($rawJson) ? $data : json_decode($data, true); 
  }
  
  
  
  
  
  // Process  the data and return it in a particular format
  public function export($data, $type, $extract_field_as_name=false)
  {
    // Determine the type of export we are looking for
    switch($type)
    {
      // For Morris JS
      case "morris":	
	return $this->morris($data, $extract_field_as_name);
	break;
      
      // Export the labels
      case "labels":	
	return $this->labels($data, $extract_field_as_name);
	break;
	
      default:
	break;
    } 
  }
  
  
  
  
  // Build the morris export
  function morris($data, $extract_field_as_name=false)
  {
    $out = array();
    $periods = $this->getFeedPeriod($data);
    foreach($periods as $period)
    {
      $out[] = $this->getFeedData($data, $period, $extract_field_as_name); 
    }    
    return json_encode($out);
  }
  
  
  
  // Build the labels Export
  function labels($data, $extract_field_as_name=false)
  {
    $out = array();
    foreach($data as $d) $out[] = $this->getFeedName($d, $extract_field_as_name);      
    return json_encode($out);
  }
  
  
  // Get the feed data based on a searching value
  function getFeedData($data, $needle, $extract_field_as_name)
  {
    $found = array();    
    // Loop through all the data
    foreach($data as $set)
    {
      // Get the name of the service based on the propberties provided     
      $name = $this->getFeedName($set, $extract_field_as_name);
      $found['period'] = date($this->dateFormat, $needle);
      
      // Loop through all the data sets and only add the information to the array as needed
      foreach($set['datapoints'] as $d)
      {
	// Build the array with the period, the feed and the value	
	if (in_array($needle, $d)) $found[$name] = round((float)$d[0], 2);	
      }      
    }
    return $found;
  }
  
  
  
    
  // Get the feed names based on an index
  function getFeedName($data, $extract_field_as_name)
  {    
    // Get the feedname
    $feedName = $data['target'];
    if ( ($extract_field_as_name)
    && ($extract_field_as_name !== "") )
    {
      $explode = explode('.', $feedName);
      if (is_array($extract_field_as_name))
      {
	$name = array();
	foreach($extract_field_as_name as $field)
	{
	  $index = (int)$field - 1;
	  $name[] = ucfirst($explode[$index]);
	}
	$feedName = implode(' ', $name);
      } else {
	$index = (int)$extract_field_as_name - 1;
	$feedName = ucfirst($explode[$index]);
      }
    }   
    return $feedName;
  }
  
  
  // Get the time for the feed
  function getFeedPeriod($data)
  {
    $periods = array();
    foreach($data as $d)
    {
      $dataFeed = $d['datapoints'];
      foreach($dataFeed as $feed)
      {	
	if (!in_array($feed[1], $periods)) $periods[] = $feed[1];
      }
    }    
    return $periods;
  }
  
}


?>