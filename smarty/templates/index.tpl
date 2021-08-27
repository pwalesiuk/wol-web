{include file="page_header.tpl"}

<h3>Maszyny</h3>
<table class="hosts" align=center>
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

<h3>Historia poczynań</h3>

<table class="hosts" align=center>
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

{include file="page_footer.tpl"}
