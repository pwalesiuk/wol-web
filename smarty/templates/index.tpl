{include file="page_header.tpl"}

<div class="row">
<div class="column left">
<table class="hosts" align=center>
<caption>Maszyny z config</caption>
<thead>
<tr>
 <th>Kto</th>
 <th>Mac</th>
 <th>Ip</th>
 <th>Up</th>
 <th>SMP</th>
</tr>
</thead>
<tbody>
{section name=s1 loop=$hosts}
<tr class="{cycle values="odd,even"}">
 <td align="center">{$hosts[s1].kto}</td>
 <td align="center">{$hosts[s1].mac}</td>
 <td align="center">{$hosts[s1].ip}</td>
 <td align="center">{$hosts[s1].up}</td>
 <td align="center"><a href='smp.php?mac={$hosts[s1].mac}' title="ślij czym prędzej pakiet magiczny">SMP</a></td>
</tr>
{/section}
</tbody>
</table>

<table class="hosts" align=center>
<caption>Dane z tablicy arp</caption>
<thead>
<tr>
 <th>Mac</th>
 <th>Ip</th>
 <th>Up</th>
 <th>SMP</th>
</tr>
</thead>
<tbody>
{section name=s1 loop=$harp}
<tr class="{cycle values="odd,even"}">
 <td align="center">{$harp[s1].mac}</td>
 <td align="center">{$harp[s1].ip}</td>
 <td align="center">{$harp[s1].up}</td>
 <td align="center"><a href='smp.php?mac={$harp[s1].mac}' title="ślij czym prędzej pakiet magiczny">SMP</a></td>
</tr>
{/section}
</tbody>
</table>
</div>

<div class="column right">

<table class="hosts" align=center>
<caption>Historia poczynań</caption>
<thead>
<tr>
 <th>Kiedy</th>
 <th>Ares</th>
 <th>Mac</th>
</tr>
</thead>
<tbody>
{section name=s2 loop=$logs}
<tr class="{cycle values="odd,even"}">
 <td align="center">{$logs[s2].date}</td>
 <td align="center">{$logs[s2].host}</td>
 <td align="center">{$logs[s2].mac}</td>
</tr>
{/section}
</tbody>
</table>

</div>
</div>
{include file="page_footer.tpl"}
