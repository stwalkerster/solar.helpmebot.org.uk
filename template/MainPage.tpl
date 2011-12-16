<h2>Last 7 days Power Generation</h2>
{foreach $graphlist as $graph}
	<h2>{$graph[1]}</h2>
	<img src="render/{$graph[0]}.png" />
{/foreach}