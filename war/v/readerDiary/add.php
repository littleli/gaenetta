<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<link rel="stylesheet" href="/static/validation.css">
<style>
option[selected] { background-color: black; }
</style>
</head>
<body>

<h1>Add book</h1>

<% if (Binder::isErrorForm($result)): %>
<div class="validation">
<% foreach ($result->rejected as $field): %>
  <% foreach ($field["notice"] as $notice): %>
    <div class="notice"><%= $notice %></div>
  <% endforeach %>
<% endforeach %>
</div>
<% endif %>

<%= form('readerDiary', 'submit', array()) %>

<label for="title">Title</label><br>
<%= textField($result, array('name'=>'title')) %><br>

<label for="author">Author</label><br>
<%= textField($result, array('name'=>'author')) %><br>

<label for="pages">Pages</label><br>
<%= textField($result, array('name'=>'pages')) %><br>

<label for="isbn">ISBN</label><br>
<%= textField($result, array('name'=>'isbn')) %><br>

<label for="link">Link</label><br>
<%= textField($result, array('name'=>'link')) %><br>

<label for="format">Format</label><br>
<input type="checkbox" name="format[]" id="paperback" value="paperback" <%=checked('paperback', $params['format'])%>><label for="paperback">Paperback</label><br>
<input type="checkbox" name="format[]" id="hardcover" value="hardcover" <%=checked('hardcover', $params['format'])%>><label for="hardcover">Hardcover</label><br>
<input type="checkbox" name="format[]" id="ebook" value="ebook" <%=checked('ebook', $params['format'])%>><label for="ebook">E-book</label><br>

<label for="rating">Rating</label><br>
<select name="rating">
 <option value="1" <%=selected('1', $params['rating'])%>>1</option>
 <option value="2" <%=selected('2', $params['rating'])%>>2</option>
 <option value="3" <%=selected('3', $params['rating'])%>>3</option>
 <option value="4" <%=selected('4', $params['rating'])%>>4</option>
 <option value="5" <%=selected('5', $params['rating'])%>>5</option>
</select><br>

<input type=submit name=Submit value=Submit>

<%= end_form() %>

</body>
</html>
