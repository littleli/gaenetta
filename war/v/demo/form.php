<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/static/validation.css"/>
</head>
<body>

<% if (Binder::isErrorForm($result)): %>
<div class="errors">
<% foreach ($result->rejected as $field): %>
  <% foreach ($field["notice"] as $notice): %>
    <div class="notice"><%= $notice %></div>
  <% endforeach %>
<% endforeach %>
</div>
<% endif %>

<%= form($controller, 'submit', array('name'=>'myform') ) %>

<%= textField($result, array('name'=>'name','class'=>'nothing')) %><label for="name">Name</label><br>
<%= textField($result, array('name'=>'pages')) %><label for="pages">Pages</label><br>
<%= textField($result, array('name'=>'isbn')) %><label for="isbn">ISBN</label><br>
<%= checkbox($result, array('name'=>'like','value'=>'1')) %><label for="like">Like?</label><br>

<input type="checkbox" id="red" name="colors[]" value="Red" <%=checked('Red', $params['colors'])%>><label for="red">Red</label><br>
<input type="checkbox" id="blue" name="colors[]" value="Green" <%=checked('Green', $params['colors'])%>><label for="blue">Green</label><br>
<input type="checkbox" id="green" name="colors[]" value="Blue" <%=checked('Blue', $params['colors'])%>><label for="green">Blue</label><br>

<input type="submit" value="Odeslat">

<%= end_form() %>

<pre style="background-color: #ccf; padding: 4px;">
<% var_dump($result->target) %>
</pre>
<pre style="background-color: #cfc; padding: 4px;">
<% var_dump($result->rejected) %>
</pre>

<!--
  <input name="name" value="<% if ($book->name): echo $book->name; else: echo $result->rejected["name"]["value"]; endif %>"/><label>Name</label><br/>
  <input name="pages" value="<% if ($book->pages): echo $book->pages; else: echo $result->rejected["pages"]["value"]; endif %>"/><label>Pages</label><br/>
  <input name="isbn" value="<% if ($book->isbn): echo $book->isbn; else: echo $result->rejected["isbn"]["value"]; endif %>"/><label>ISBN</label><br/>
  <input type="submit" value="Odeslat"/>
-->

<h2><%= "čučorietky" %></h2>
<ol>
<% foreach ($books as $book): %>
<li>
<% echo "${book->name}, ${book->pages} stran" %>
<% if ($book->isbn): %><%= ", isbn: ${book->isbn}" %><% endif %>
<% if ($book->like): %><%= ", like: ${book->like}" %><% endif %>
<% if ($book->colors): %>
<% foreach ($book->colors as $color): %><%= " [$color] " %><% endforeach %>
<% endif %>
<% $html = new Html; $html->a('(X)', array("href"=>"/demo/delete/${book->keyToString()}")); $html(); %>
</li>
<% endforeach %>
</ol>

</body>
</html>
