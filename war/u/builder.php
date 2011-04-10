<%
require_once("Html.php");

$html = new Html;

$html->open_html();
$html->open_body();
$html->h1("Hello world", array("class" => "first"));
$html->h2("Hello", array("class" => "trida"));
$html->p("Paragraph", array("class" => "emblem"));
$html->br();

$html->container("ul", array("class" => "list"), array(
  $html->_li("jedna"), 
  $html->_li("dva")
));

$html->input(array("type"=>"checkbox","name"=>"mujcheckbox","value"=>10,"checked"=>NULL));

$html->close_body();
$html->close_html();

$html();
%>
