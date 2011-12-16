        <div class="row">
          <div class="span16">
<h2>{$graphlisttitle}</h2>
{foreach from="$graphlist" item="graph"}
	<h3>{$graph[1]}</h3>
	<img src="render/{$graph[0]}.png" />
{/foreach}          </div>
        </div>
