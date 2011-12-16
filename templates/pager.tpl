<div class="pagination">
  <ul>
	<li class="prev{if $offset eq 0} disabled{/if}"><a {if $offset neq 0}href="?offset={$offset-1}"{/if}>&larr; Previous</a></li>
	<li {if $offset eq 0}class="active"{/if}><a href="?offset={if $offset > 1}{$offset-2}{else}0{/if}">{if $offset > 1}{$offset-1}{else}1{/if}</a></li>
	<li {if $offset eq 1}class="active"{/if}><a href="?offset={if $offset > 1}{$offset-1}{else}1{/if}">{if $offset > 1}{$offset}{else}2{/if}</a></li>
	<li {if $offset > 1}class="active"{/if}><a href="?offset={if $offset > 1}{$offset}{else}2{/if}">{if $offset > 1}{$offset+1}{else}3{/if}</a></li>
	<li><a href="?offset={if $offset > 1}{$offset+1}{else}3{/if}">{if $offset > 1}{$offset+2}{else}4{/if}</a></li>
	<li><a href="?offset={if $offset > 1}{$offset+2}{else}4{/if}">{if $offset > 1}{$offset+3}{else}5{/if}</a></li>
	<li class="next"><a href="?offset={$offset+1}">Next &rarr;</a></li>
  </ul>
</div>