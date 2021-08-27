{include file="page_header.tpl"}

{if $mode eq 'd'}daily{else}<a href="{$smarty.server.script_name}?net={$net}&m=d">daily</a>{/if}
 |
{if $mode eq 'w'}weekly{else}<a href="{$smarty.server.script_name}?net={$net}&m=w">weekly</a>{/if}
 |
{if $mode eq 'm'}monthly{else}<a href="{$smarty.server.script_name}?net={$net}&m=m">monthly</a>{/if}

<table>
<tr align=center>
 <td><a href="{$sl}&sort_mode=period_{if $sort_mode eq 'period_asc'}desc{else}asc{/if}">period</a></td>
 <td colspan=2><a href="{$sl}&sort_mode=tx_{if $sort_mode eq 'tx_asc'}desc{else}asc{/if}">tx</a></td>
 <td colspan=2><a href="{$sl}&sort_mode=rx_{if $sort_mode eq 'rx_asc'}desc{else}asc{/if}">rx</a></td>
 <td><a href="{$sl}&sort_mode=sx_{if $sort_mode eq 'sx_asc'}desc{else}asc{/if}">total</a></td>
</tr>
{section name=s1 loop=$stats}
{math assign=zwidth equation="x / (y + 1) * z" x=$stats[s1].tx y=$totals.tx z=$bar_width}
{math assign=dwidth equation="x / (y + 1) * z" x=$stats[s1].rx y=$totals.rx z=$bar_width}
<tr align=right>
 <td><a href="network.php?net={$net}&m={$mode}&v={$stats[s1].period}">{$stats[s1].period}</a></td>
 <td><img src="gfx/bar_in.png" height="{$bar_height}" width="{$zwidth}"></td>
 <td>{$stats[s1].tx|disp_bytes}</td>
 <td><img src="gfx/bar_out.png" height="{$bar_height}" width="{$dwidth}"></td>
 <td>{$stats[s1].rx|disp_bytes}</td>
 <td>{$stats[s1].sx|disp_bytes}</td>
</tr>
{/section}
<tr align=right>
 <td>total</td>
 <td><img src="gfx/bar_in.png" height="{$bar_height}" width="{$bar_width}"></td>
 <td>{$totals.tx|disp_bytes}</td>
 <td><img src="gfx/bar_out.png" height="{$bar_height}" width="{$bar_width}"></td>
 <td>{$totals.rx|disp_bytes}</td>
 <td>{$totals.sx|disp_bytes}</td>
</tr>
</table>


{include file="page_footer.tpl"}
