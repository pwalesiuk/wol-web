{include file="page_header.tpl"}

<center>
[ <a href="index.php">netstats</a> > 
<a href="network.php?net={$net}">{$net}</a> > 
{$host} ]<br>
<h1>Statystyki komputera {$host}</h1>
{foreach from=$wykresy item=czas}
<img src="images/bits-{$host}-last-{$czas}.png"><br>
{/foreach}
</center>

{include file="page_footer.tpl"}
