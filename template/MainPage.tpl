Welcome!
<h1>Last 7 days Power Generation</h1>
{foreach $graphlist as $graph}
	<h2>{$graph[1]}</h2>
	<img src="render/{$graph[0]}.png" />
{/foreach}