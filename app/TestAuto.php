<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>

	<!--<script src="./JQueryUI/cb=gapi.loaded_1" async=""></script>
<script src="./JQueryUI/cb=gapi.loaded_0" async=""></script>
<script type="text/javascript" async="" src="./JQueryUI/plusone.js" gapi_processed="true"></script>-->
<script src="./JQueryUI/jquery-1.7.1.min.js"></script>
<script src="./JQueryUI/jquery.ui.core.min.js"></script>
<script src="./JQueryUI/jquery.ui.widget.min.js"></script>
<script src="./JQueryUI/jquery.ui.position.min.js"></script>
<script src="./JQueryUI/jquery.ui.autocomplete.min.js"></script>
<link rel="stylesheet" href="http://www.jqueryautocomplete.com/js/jquery/smoothness/jquery-ui-1.8.16.custom.css">

<!--<base href="http://www.jqueryautocomplete.com/">--><base href=".">

<link href="./JQueryUI/global.css" rel="stylesheet" type="text/css">


<!-- prettify -->
<!-- SyntaxHighLighter -->
<script type="text/javascript" src="./JQueryUI/shCore.js"></script>
<script type="text/javascript" src="./JQueryUI/shBrushPhp.js"></script>
<script type="text/javascript" src="./JQueryUI/shBrushXml.js"></script>
<!--
<link href="js/syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css" />
<link href="js/syntaxhighlighter/styles/shCoreDefault.css" rel="stylesheet" type="text/css" />
-->
<link href="./JQueryUI/shThemePhpBook.css" rel="stylesheet" type="text/css">

<!--
-->
<script type="text/javascript">
SyntaxHighlighter.defaults['gutter'] = false;
SyntaxHighlighter.all();
</script>
<style type="text/css">
/*

*/
.syntaxhighlighter, pre{
	/*-moz-border-radius:5px;
	-khtml-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	border:2px solid #b7d2ed;*/
	padding:10px;
	
	font-family:"Courier New", Courier, monospace  !important;
	font-size:12px !important;;
	border:1px solid  #eee  !important;
	margin:10px 0 !important;
	background-color: #fbfbfb !important;


	-moz-border-radius:5px;
	-khtml-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	padding:10px;
	background-color: #eee !important;
	border:1px solid  #cccccc  !important;
	color:#111111;

}
code{
}
.fluo{
	background-color:#EEE;
	-moz-border-radius:2px;
	-khtml-border-radius:2px;
	-webkit-border-radius:2px;
	border-radius:2px;
	padding:0 3px;
	};

</style>


 </head>
 <body>

 <script>

var data = [
				{"label":"Aragorn"},
				{"label":"Arwen"},
				{"label":"Bilbo Baggins"},
				{"label":"Boromir"},
				{"label":"Frodo Baggins"},
				{"label":"Gandalf"},
				{"label":"Gimli"},
				{"label":"Gollum"},
				{"label":"Legolas"},
				{"label":"Meriadoc Merry Brandybuck"},
				{"label":"Peregrin Pippin Took"},
				{"label":"Samwise Gamgee"}
				];
$(function() {

	/*$( "#search" ).autocomplete(
	{
		 source:data,
	})	*/

	$( "#search" ).autocomplete(
	{
		 source:'http://localhost/jpos/app/Json.php',
	})

});



</script>

<p>Search: <input type="text" id="search" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"></p>

  
 </body>
</html>
