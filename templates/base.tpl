<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{$pagetitle}</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="{$cWebPath}/bootstrap/bootstrap.css" rel="stylesheet">
	<style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
	
	<!-- styles -->
	{foreach from="$styles" item="thisstyle"}
		<link rel="stylesheet" type="text/css" href="{$thisstyle}" />
	{/foreach}
	
	<!-- scripts -->
	{foreach from="$scripts" item="thisscript"}
		<script src="{$thisscript}" type="text/javascript"></script>
	{/foreach}
  </head>

  <body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">{$pagetitle}</a>
          <ul class="nav">
			{foreach from="$mainmenu" item="menuitem" }
				<li {if isset($menuitem.current)}class="active"{/if}><a href="{$cScriptPath}{$menuitem.link}" >{$menuitem.title}</a></li>
			{/foreach}
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="sidebar">
        <div class="well">
          <h4>Sidebar</h4>
		    {foreach $generation as $genitem}
	            <h5>{$genitem@key}</h5>
	            <p>{$genitem}</p>
			{/foreach}
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