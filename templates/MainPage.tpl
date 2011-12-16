<h2>Last 7 days Power Generation</h2>
{foreach $graphlist as $graph}
	<h3>{$graph[1]}</h3>
	<img src="render/{$graph[0]}.png" />
{/foreach}