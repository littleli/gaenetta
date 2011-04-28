<!DOCTYPE html>
<html>
<head>
<link rel=stylesheet href="/static/validation.css">
<link rel=stylesheet href="/static/star-rating.css">
<style>
.book { padding-bottom: 1em }
</style>
</head>
<body>

<h1>Book list</h1>

<% if (!$entries): %>
<div class="info">No books available</div>
<% endif %>

<div id="main">
<% $counter = 0 %>
<% foreach ($entries as $book): %>
<% $parity = $counter++ % 2 ? 'even' : 'odd' %>
<div class="book <%= $parity %>">
Title: <%= $book->title %>,
Author: <%= $book->author %>,
Pages: <%= $book->pages %>,
<% if ($book->isbn): %>ISBN: <%= $book->isbn %>,<% endif %>
<% if ($book->link): %>Link: <% $link = new Html; $link->a( $book->title, array('href'=>$book->link)); $link(); %>, <% endif %>

Format: 
<% if (is_array($book->format)): %>
<%= implode(', ', $book->format) %>
<% else: %>
<%= $book->format %>
<% endif %>

<ul class='star-rating'>
  <li class='current-rating' style='width:<%= ($book->rating)*25 %>px;'>Currently <%= $book->rating %>/5 Stars.</li>
  <% foreach (array(1=>'one', 2=>'two', 3=>'three', 4=>'four', 5=>'five') as $num => $strnum): %>
  <li><span title='<%=$num%> star out of 5' class='<%=$strnum%>-star'><%=$num%></span></li>
  <% endforeach %>
</ul>

</div>
<% endforeach %>

</div>

<div>
<% if ($current_user): %>

<%= "User: $current_user" %>
<% if (Users::isUserAdmin()): %>
, Role: Admin

<% endif %>
<br>
<a href="/readerDiary/add">Add</a><br>
<a href="<%= $logout_url %>">logout</a>
<% else: %>
<a href="<%= $login_url %>">login</a>
<% endif %> 
</div>

</body>
</html>
