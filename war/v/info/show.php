<html>
  <body>
   <h1>Nadpis</h1>
   <ul>
    <% foreach (array("jedna" => 1, "dva" => 2) as $key => $value): %>
      <% if ($value % 2): %>
      <li><% echo "$key : $value"; %></li>
      <% endif; %>
    <% endforeach; %>
</html>
