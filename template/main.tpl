
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{$documenttitle}</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="bootstrap/bootstrap.css" rel="stylesheet">
	<style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">{$pagetitle}</a>
          <ul class="nav">
            <li class="active"><a href="#">Home</a></li>
			{foreach $menu as $menuitem}
				<li><a href="{$menuitem}">{$menuitem@key}</a></li>
			{/foreach}
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="sidebar">
        <div class="well">
          <h4>Sidebar</h4>
		  {*            {foreach $generation as $genitem}
	            <h2>{$genitem@key}</h2>
	            <p>{$genitem}</p>
	            <p></p>
			{/foreach}*}
        </div>
      </div>
      <div class="content">
        <div class="row">
          <div class="span16">
			{include file=$content}
          </div>
        </div>

        <footer>
          <p>&copy; Company 2011</p>
        </footer>
      </div>
    </div>

  </body>
</html>