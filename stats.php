<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Monitoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style>
      body {
        padding-top: 40px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>           
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href="index.html">Dashboard</a></li>
                    <li class="active"><a href="stats.php">Status</a></li>
                    <li><a href="history.html">Alert History</a></li>
                    <li><a href="admin.html">Admin Console</a></li>
                </ul>
            </div><!--/.nav-collapse -->
          
            <ul class="nav pull-right">                
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class='icon-white icon-user'></i> Login <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <form action="login.html" id="form_login" accept-charset="utf-8" method="post">
                            <fieldset class="control-group">  
                                <input type="text" class="span2" name="username" placeholder="Username">
                            </fieldset>
                            <fieldset class="control-group">
                                <input type="password" class="span2" name="password" placeholder="Passsword" />
                            </fieldset>
                            <fieldset class="control-group">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </fieldset>
                        </form> 
                    </ul>
                </li>
            </ul>
        </div>
      </div>
    </div>
    
    <div class="container">      
       <h1 class="page-header">Statistics</h1>       
    </div>
       
    <div class="container graph" data='roundtrip' goal="30">      
       <h3 class="page-header">Telfree Roundtrip</h3>
       <div class="holder" style="height: 250px;"></div>
    </div>
    
    <div class="container graph" data='web' goal="1.5">      
       <h3 class="page-header">Average API Response</h3>
       <div class="holder" style="height: 250px;"></div>
    </div>
        
    <div class="container graph" data='http' goal="1.5">           
       <h3 class="page-header">HTTP API Response</h3>
       <div class="holder" style="height: 250px;"></div>
    </div>
        
    <div class="container graph" data='xml' goal="1.5">           
       <h3 class="page-header">XML API Response</h3>
       <div class="holder" style="height: 250px;"></div>
    </div>
        
    <div class="container graph" data='smpp' goal="1.5">          
       <h3 class="page-header">SMPP API Response</h3>
       <div class="holder" style="height: 250px;"></div>
    </div>  
    
    <!--<div class="container">
      <h4>API Response Times</h4>
      <div class="btn-group">
	<a href="#" class="btn active">HTTP</a>
	<a href="#" class="btn ">XML</a>
	<a href="#" class="btn ">SOAP</a>
	<a href="#" class="btn ">SMPP</a>
	<a href="#" class="btn ">SMTP</a>
	<a href="#" class="btn ">FTP</a>
	<a href="#" class="btn ">COM</a>
	<a href="#" class="btn ">Connect</a>
      </div>
      <br /><br />
      <div class="thumbnail">
	<img src="http://10.248.4.145/render/?width=960&fontSize=14&height=300&_salt=1362046875.032&drawNullAsZero=true&from=-120minutes&lineWidth=2&target=Uptime.*.http.*&title=HTTP%20API%20Response%20Times" />
      </div>
      <br />
      <h4>Vendor Response Times</h4>
      <div class="btn-group">
	<a href="#" class="btn active">CyberSource</a>
	<a href="#" class="btn ">Durango</a>
	<a href="#" class="btn ">PayPal</a>
      </div>
      <br /><br />
      <div class="thumbnail">
	<img src="http://10.248.4.145/render/?width=960&fontSize=14&height=300&_salt=1362046875.032&drawNullAsZero=true&from=-120minutes&lineWidth=2&target=Uptime.*.cybersource.*&title=XML%20API%20Response%20Times" />
      </div>
      
    </div> -->   
  

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>    
    <script src="js/raphael-min.js"></script>
    <script src="js/morris.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
