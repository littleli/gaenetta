<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.error {
  background-color: #fcc;
}
</style>
</head>
<body>
<div class="validations">
<% foreach ($result->rejected as $field): %>
  <% foreach ($field["notice"] as $notice): %>
    <div class="notice"><%= $notice %></div>
  <% endforeach %>
<% endforeach %>
</div>
<%= $tags->form(array('action'=>'submit','name'=>'myform')) %>
<%= $tags->textField(array('name'=>'name','value'=>$book->name, 'class'=>'nothing'), $result) %><label for="name">Name</label><br/>
<%= $tags->textField(array('name'=>'pages','value'=>$book->pages), $result) %><label for="pages">Pages</label><br/>
<%= $tags->textField(array('name'=>'isbn','value'=>$book->isbn), $result) %><label for="isbn">ISBN</label><br/>
<%= $tags->checkboxField(array('name'=>'like', 'value'=>true), $result) %><label for="like">Like?</label><br/>
<!-- %= $tags->checkboxGroup(array('name'=>'colors','values'=>array('red', 'yellow', 'blue')), $result) %><br/ -->

<input type="checkbox" name="colors[]" value="Red" <%= in_array('Red', $params['colors']) ? 'checked' : '' %>><label for="red">Red</label><br/>
<input type="checkbox" name="colors[]" value="Green" <%= in_array('Green', $params['colors']) ? 'checked' : '' %>><label for="blue">Green</label><br/>
<input type="checkbox" name="colors[]" value="Blue" <%= in_array('Blue', $params['colors']) ? 'checked' : '' %>><label for="green">Blue</label><br/>


<input type="submit" value="Odeslat"/>

<pre>
<% var_dump($result->target) %>
</pre>

<!--
  <input name="name" value="<% if ($book->name): echo $book->name; else: echo $result->rejected["name"]["value"]; endif %>"/><label>Name</label><br/>
  <input name="pages" value="<% if ($book->pages): echo $book->pages; else: echo $result->rejected["pages"]["value"]; endif %>"/><label>Pages</label><br/>
  <input name="isbn" value="<% if ($book->isbn): echo $book->isbn; else: echo $result->rejected["isbn"]["value"]; endif %>"/><label>ISBN</label><br/>
  <input type="submit" value="Odeslat"/>
-->
<%= $tags->endform() %>

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
