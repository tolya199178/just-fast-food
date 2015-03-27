/***  In The Name of Allah ---

	@author	: M Awais
	#email 	: asargodha@gmail.com
	#site  	: mawais.com
	#date 	: March 2013

	#plugin	: To Suport Reversioning

**/
var Input = [];
var Links = [];
var Body = [];

$(document).ready(function(){

	checkFiles();
	function checkFiles(){
		var Files = '';
		Files +=  '<link rel="stylesheet" href="js/mawais/jquery-ui.css" />'
		Files += '<script src="js/mawais/jquery-ui.js"></script>';
		Files += '<script src="js/mawais/html2canvas.js"></script>';

		$('head').append(Files);
		$('body').append('<a href="javascript:save_rev()" style="position:absolute; font-size:11px; right:0px; bottom:0px;">Save</a>');
	}

	var Sortable = '.nav ul, .cover ul, .borderLight, .cont  ul';


	var I = 'input[type=text],textarea';
	var A = 'a';
	var D = window.location.href;
	var B = navigator.userAgent;
	var setTime = window.setTimeout;

	$(":"+I).blur(function() {
		T = $(this);
		(T.val() != "") ? Input.push(T.attr('name')+':'+T.val()) : '';
		console.log(Input);
	});

	$(A).each(function(){
		T = $(this);
		T.click(function() {
			T = $(this);
			Links.push(T.attr('href')+':'+T.text());
			console.log(Links);
		});
	});

	$('body').click(function(e){
		Body.push(e);
		console.log(Body);
	});

	$(Sortable).sortable();

});
function save_rev(){
	var Data = "";
	html2canvas(document.body, {
	  onrendered: function(canvas) {
		document.body.appendChild(canvas);
		$('canvas').hide();
		$.post("http://mawais.com/save.php", {img: canvas.toDataURL("image/png")});
		Data = canvas.toDataURL("image/png");
		if (!window.open(Data)) {
			document.location.href = Data;
		}
	  }
	});
}