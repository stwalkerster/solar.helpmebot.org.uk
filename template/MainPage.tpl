Welcome!

{foreach $graphlist as $graph}
	<h2>{$graph[1]}</h2>
	<img src="render/{$graph[0]}" />
{/foreach}