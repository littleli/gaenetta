<!DOCTYPE html>
<html>
<body>

<h1><%= $view %></h1>

<pre>
<%= var_dump($headers) %>
</pre>

<pre>
<%= var_dump($session) %>
</pre>

<table>
  <caption>Cloud status</caption>
  <thead>
  	<tr>
  	  <td>Service</td>
  	  <td>Status</td>
  	  <td>Maintaince</td>
  	</tr>
  </thead>
  <tbody>    
  	<% foreach ($capabilities as $service => $props): %>
  	<tr>
  	  <td><%= $service %></td>
  	  <td><%= $props["status"] %></td>
  	  <td><%= isset($props["maintaince"]) ? $props["maintaince"] : "Not planned" %></td>
  	</tr>
  	<% endforeach; %>
  </tbody>
</table>

</body>
</html>
