        <div class="row">
          <div class="span16">
<h2>{$graphlisttitle}</h2>
{foreach from="$graphlist" item="graph"}
	<h3>{$graph[1]}</h3>
	<img src="{$cWebPath}/render/{$graph[0]}.png" />
{/foreach}          </div>
        </div>

		
<div class="pagination">
  <ul>
  
    <li class="prev{if $offset neq 0} disabled{/if}"><a {if $offset neq 0}href="?offset={$offset-1}"{/if}>&larr; Previous</a></li>
    <li {if $offset eq 1}class="active"{/if}><a href="#">{if $offset > 2}{$offset-2}{else}1{/if}</a></li>
    <li {if $offset eq 2}class="active"{/if}><a href="#">{if $offset > 2}{$offset-1}{else}2{/if}</a></li>
    <li {if $offset > 2}class="active"{/if}><a href="#">{if $offset > 2}{$offset}{else}3{/if}</a></li>
    <li><a href="#">{if $offset > 2}{$offset}{else}4{/if}</a></li>
    <li><a href="#">{if $offset > 2}{$offset}{else}5{/if}</a></li>
    <li class="next"><a href="#">Next &rarr;</a></li>
  </ul>
</div>