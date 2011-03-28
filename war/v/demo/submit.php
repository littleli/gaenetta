<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset=utf-8>
<body>

<h1>Form</h1>

<h2>Rejected</h2>
<pre>
<%= var_dump($result->rejected) %>
</pre>

<h2>Bound</h2>
<pre>
<% if (is_object($result->target)): %>
<%= var_dump($book->get()->properties) %>
<% endif %>
<% if (is_array($result->target)): %>
<%= var_dump($result->target) %>
<% endif %>
</pre>

</body>
</html>
