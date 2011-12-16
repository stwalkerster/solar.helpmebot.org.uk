<div class="row">
	<div class="span16">
		<h2>{$graphlisttitle}</h2>
		{include file="pager.tpl"}
		{foreach from="$graphlist" item="graph"}
			<h3>{$graph[1]}</h3>
			<img src="{$cWebPath}/render/{$graph[0]}.png" />
		{/foreach}
		{include file="pager.tpl"}
	</div>
</div>