<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <title>{$documenttitle}</title>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

  <!-- **** layout stylesheet **** -->
  <link rel="stylesheet" type="text/css" href="style/style.css" />

  <!-- **** colour scheme stylesheet **** -->
  <link rel="stylesheet" type="text/css" href="style/colour.css" />

</head>

<body>
  <div id="main">
    <div id="links">
      <!-- **** INSERT LINKS HERE **** -->
      <a href="#">another link</a> | <a href="#">another link</a> | <a href="#">another link</a> | <a href="#">another link</a>
    </div>
    <div id="logo"><h1>{$pagetitle}</h1></div>
    <div id="content">
      <div id="menu">
        <ul>
        {foreach $menu as $menuitem}
			<li><a href="{$menuitem}">{$menuitem@key}</a></li>
		{/foreach}
        </ul>
      </div>
      <div id="column1">
        <div class="sidebaritem">
          <div class="sbihead">
            <h1>latest generation:</h1>
          </div>
          <div class="sbicontent">
            {foreach $generation as $genitem}
	            <h2>{$genitem@key}</h2>
	            <p>{$genitem}</p>
	            <p></p>
			{/foreach}
          </div>
        </div>
      </div>
      <div id="column2">
		{$content}
      </div>
    </div>
    <div id="footer">
      copyright &copy; 2010 Simon Walker | <a href="mailto:stwalkerster@helpmebot.org.uk">stwalkerster@helpmebot.org.uk</a> | <a href="http://validator.w3.org/check?uri=referer">XHTML 1.1</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.dcarter.co.uk">design by dcarter</a>
    </div>
  </div>
</body>
</html>
