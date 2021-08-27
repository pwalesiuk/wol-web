{include file="page_header.tpl"}

<center>
[ <a href="index.php">netstats</a> >
{$net} ]<br>
<h2>Statystyki ruchu dla komputerów z sieci {$net}</h2>
</center>

<table align=center bgcolor=black cellpadding="4">
<tr bgcolor="#94ABC0" align=center>
<td rowspan=2><b>Pozycja</b></td>
<td rowspan=2>
<a href="{$smarty.server.SCRIPT_NAME}?net={$net}&sort_mode=nr_{if $sort_mode eq 'nr_asc'}desc{else}asc{/if}">komputer</a>
</td>
<td colspan=5><b>Statystyki ruchu</b></td>
</tr>
<tr bgcolor="#94ABC0" align=center>
<td colspan=3>
<a href="{$smarty.server.SCRIPT_NAME}?net={$net}&sort_mode=bytes_src_{if $sort_mode eq 'bytes_src_asc'}desc{else}asc{/if}">in</a> /
<a href="{$smarty.server.SCRIPT_NAME}?net={$net}&sort_mode=bytes_dst_{if $sort_mode eq 'bytes_dst_asc'}desc{else}asc{/if}">out</a></td>
<td colspan=2>
<a href="{$smarty.server.SCRIPT_NAME}?net={$net}&sort_mode=ratio_{if $sort_mode eq 'ratio_asc'}desc{else}asc{/if}">ratio</a>
</td>
</tr>
{section name=s1 loop=$stats}
{if $stats[s1].sx > 0}
{math assign=dwidth equation="x / (y + 1) * z" x=$stats[s1].rx y=$totals.rx z=$bar_width}
{math assign=dproc format="%.2f" equation="x / (y + 1) * 100" x=$stats[s1].rx y=$totals.rx}
{math assign=zwidth equation="x / (y + 1) * z" x=$stats[s1].tx y=$totals.tx z=$bar_width}
{math assign=zproc format="%.2f" equation="x / (y + 1) * 100" x=$stats[s1].tx y=$totals.tx}
<tr bgcolor="{cycle values="#EDEDED,#ffffff" advance=false}">
    <td rowspan=2>{$smarty.section.s1.iteration}</td>
    <td rowspan=2>{$stats[s1].adres}</td>
    <td><img src="gfx/bar_out.png" height="{$bar_height}" width="{$dwidth}"></td>
    <td>{$stats[s1].rx|disp_bytes}</td>
    <td>[{$dproc}%]</td>
    <td rowspan=2 align=center>
      <img src="gfx/bar_out.png" height="{$bar_height}" width="{math equation="x / (x + y + 1) * z" x=$stats[s1].rx y=$stats[s1].tx z=$bar_width}"><img src="gfx/bar_in.png" height="{$bar_height}" width="{math equation="y / (x + y + 1) * z" x=$stats[s1].rx y=$stats[s1].tx z=$bar_width}"><br>
      [{math format="%.2f" equation="x / (x + y + 1) * 100" x=$stats[s1].rx y=$stats[s1].tx}% : {math format="%.2f" equation="y / (x + y + 1) * 100" x=$stats[s1].rx y=$stats[s1].tx}%]
    </td>
    <td rowspan=2 align=center>
      <a href="host.php?host={$stats[s1].adres}">wykres</a>
    </td>
</tr> 
<tr bgcolor="{cycle}">
    <td><img src="gfx/bar_in.png" height="{$bar_height}" width="{$zwidth}"></td>
    <td>{$stats[s1].tx|disp_bytes}</td>
    <td>[{$zproc}%]</td>
</tr>
{/if}
{/section}
<tr bgcolor="{cycle values="#EDEDED,#ffffff" advance=false}">
    <td rowspan=2>totals</td>
    <td rowspan=2>{$totals.adres}</td>
    <td><img src="gfx/bar_out.png" height="{$bar_height}" width="{$bar_width}"></td>
    <td>{$totals.rx|disp_bytes}</td>
    <td>[100%]</td>
    <td rowspan=2 align=center>
      <img src="gfx/bar_out.png" height="{$bar_height}" width="{math equation="x / (x + y + 1) * z" x=$totals.rx y=$totals.tx z=$bar_width}"><img src="gfx/bar_in.png" height="{$bar_height}" width="{math equation="y / (x + y + 1) * z" x=$totals.rx y=$totals.tx z=$bar_width}"><br>
      [{math format="%.2f" equation="x / (x + y + 1) * 100" x=$totals.rx y=$totals.tx}% : {math format="%.2f" equation="y / (x + y + 1) * 100" x=$totals.rx y=$totals.tx}%]
    </td>
    <td rowspan=2 align=center>
      <a href="host.php?host={$totals.host}">wykres</a>
    </td>
</tr> 
<tr bgcolor="{cycle}">
    <td><img src="gfx/bar_in.png" height="{$bar_height}" width="{$bar_width}"></td>
    <td>{$totals.tx|disp_bytes}</td>
    <td>[100%]</td>
</tr>
</table>

<br><br>
<table align=center>
<tr><td colspan=2 bgcolor="#94ABC0" align=center><b>Legenda</b></tr>
<tr><td align=center><img src="gfx/bar_in.png" height="10" width="30"><td align=left>ruch wchodziący</tr>
<tr><td align=center><img src="gfx/bar_out.png" height="10" width="30"><td align=left>ruch wychodzący</tr>
</table>

{*debug*}
{include file="page_footer.tpl"}
