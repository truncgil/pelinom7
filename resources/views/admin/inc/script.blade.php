<?php seri(); // serialize form

 ?>

<script type="text/javascript">



CKEDITOR.replace( 'editor', {

    language: '{{App::getLocale()}}',

	removePlugins: 'image',

	extraPlugins: 'base64image'

  

});
$(".cevapla-soru").on("click",function(){
	var bu = $(this);
	var id = bu.attr("data-soru");
	
	bu.html("Kaydediliyor...");
	$.post("{{url("admin-ajax/cevap-soru")}}",{
		soru_id : id,
		_token : "{{csrf_token()}}",
		cevap :  $("#soru"+id).val(),
		tak_duzey :  $("#tak"+id).val()
	},function(d){
		console.log(d);
		bu.html("Kaydedildi");
	});
});
$(".serialize").on("submit",function(){
	for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].updateElement();
    };
	var bu = $(this);
	bu.find(".right-fixed button").html("İşlem yapılıyor...");
	bu.find("[type='submit']").html("İşlem yapılıyor...");
	$.ajax({
		type : $(this).attr("method"),
		url : $(this).attr("action"),
		data : $(this).serialize(),
		success: function(d){
			bu.find(".right-fixed button").html("Değişiklikler Kaydedildi");
			bu.find("[type='submit']").html("Değişiklikler Kaydedildi");
			$(".result-ajax").html(d);
		}

	});
	
	return false;

});
$(".ckeditor").each(function(){

	var id = "editor"+Math.floor(Math.random() *1000);

	$(this).attr("id",id);

	

});



$(".ckeditor").each(function(){

	CKEDITOR.replace( $(this).attr("id"), {

		language: '{{App::getLocale()}}',

		extraPlugins: 'base64image'

	  

	});

});





</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="{{url('assets/touch.js')}}"></script>	

<script>

	$( function() {

		

		$(".nav-ajax a").on("click",function(){

			var id = $(this).attr("href");

			var path = $(this).parent().parent().attr("path");

			var url = id.replace("#","");

			console.log(path);

			$(id).html('<i class="fa fa-spin fa-spinner"></i>').load("?ajax2="+path+"."+url);

		});

		$(".nav-ajax li:eq(0) a").trigger("click");

		/*

		$("[type='number']").on("keypress",function(e){

			console.log(e.keyCode);

			

			if(e.keyCode==48) {

				if($(this).val().length==0) {

					return false;

				}

			}

			if(e.keyCode==46) {

				return false;

			}

		});

		*/

	//	$("[name='Tonnage']").attr("type","text").prop("type","text").mask('#,0000', {reverse: true});

		$("[name='Tonnage']")

			.attr("pattern","[0-9]+([\.,][0-9]+)?")

			.prop("pattern","[0-9]+([\.,][0-9]+)?")

			.attr("min","0")

			.prop("min","0")

			.attr("step","0.0001")

			.prop("step","0.0001");

		$("[name='Tonnage']").focusout(function(){

		   var inputVal = this.value;

		   if(inputVal.indexOf(',') != -1){

			  var num = inputVal.split(',');

			  this.value = parseInt(num)+","+num[1];

		   } else if(inputVal.indexOf('.') != -1){

			  var num = inputVal.split('.');

			  this.value = parseInt(num)+"."+num[1];

		   }

		});



		$("[name='week']").css("min-width","50px");

		$(".nav-link.active").trigger("click");

		$('form').attr('autocomplete','off');

		$( ".sortable" ).sortable({

			stop: function(evt, ui) {

				var k = 0;

				var data = [];

				$(".sortable > *").each(function(){

					//console.log($(this).attr("id2"));

					data.push([k,$(this).attr("id2")]);

					k++;

				});

				data = JSON.stringify(data);

				console.log(data);

				$.post("{{url('admin-ajax/content-sort')}}",{

					data : data,

					_token : "{{ csrf_token() }}"

				});

				

			}

		});

		$( ".draggable" ).draggable();

		$( "ul, li" ).disableSelection();

	} );

	</script>

<script>jQuery(function(){ Codebase.helpers('magnific-popup','notify','datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs'); });</script>



<script type="text/javascript">

$(document).ready(function() {



	



	

	//$('.table').DataTable();

	@if (\Session::has('mesaj'))

	Codebase.helpers('notify', {

		align: 'center',             // 'right', 'left', 'center'

		from: 'bottom',                // 'top', 'bottom'

		type: 'info',               // 'info', 'success', 'warning', 'danger'

		icon: 'fa fa-info mr-5',    // Icon class

		message: '{!! __(\Session::get('mesaj')) !!}'

	});

	@endif

	@if (\Session::has('hata'))

	Codebase.helpers('notify', {

		align: 'center',             // 'right', 'left', 'center'

		from: 'bottom',                // 'top', 'bottom'

		type: 'danger',               // 'info', 'success', 'warning', 'danger'

		icon: 'fa fa-info mr-5',    // Icon class

		message: "{!! __(\Session::get('hata')) !!}"

	});

	@endif

	

  $('#summernote,.editor').summernote({

	  height: 200,

	  width:800

  });

  function trigger() {

	   $(".ajax_modal").on("click",function(){

	 $("#modal-popin .modal-dialog").addClass("modal-lg"); 

	 $("#modal-popin .block-title").html($(this).attr("title")); 

	 $("#modal-popin .block-content").html("{{e2("Yükleniyor...")}}").load($(this).attr("href"));

	 $(".modal-footer").hide();

	$("#modal-popin").modal(); 

	return false;

	

  });

  $("[teyit]").on("click",function(){

	 $("#modal-popin .block-title").html($(this).attr("title")); 

	 $("#modal-popin .block-content").html($(this).attr("teyit")); 

$("#modal-popin .modal-dialog").removeClass("modal-lg"); 

 $(".modal-footer").show();

	 var ajax = $(this).attr("ajax");

	 var url = $(this).attr("href");

	 if(ajax==undefined) {

		$("#modal-popin .tamam").prop("href",url).removeAttr("data-dismiss");  

	 } else {

		 console.log(ajax);

		 $("#modal-popin .tamam").on("click",function(){

			 $(ajax).fadeOut();

			  $.get(url,function(){

				 

				 

			 });

		 });

		

	 }

	 

	 $("#modal-popin").modal(); 

	 return false;

	  

  });

  }

  trigger();

 

  /*

  $("[ajax]").on("click",function(){

	var yer = $(this).attr("ajax");

	$(yer).html("{{e2("Yükleniyor...")}}").load($(this).href("href"));

	return false;

  });

  */

  /*

  $("[data-ajax]").each(function(){

	  var ajax = $(this).attr("data-ajax");

	//  alert(ajax);

	  if(ajax!="") {

		  $(this).load("{{e2("Loading")}}").load("?ajax2="+ajax); 

	  }

	 

  });

  */

  $(".yayinla").on("click",function(){

	 var y;

	 if($(this).is(":checked")) {

		 y=1;

	 } else {

		 y=0;

	 }

	var bu = $(this);

	  bu.prop("disabled",true);

	 $.post("{{ url('admin-ajax/input-edit') }}",{

		 table 	: "contents",

		 value 	: y,

		 _token : "{{ csrf_token() }}",

		 id 	: bu.attr("id"),

		 name	: "y"

		 

	 },function(){

		 bu.prop("disabled",false);

		 

	 }); 

  });

  $(".edit").on("blur",function(){

	  var bu = $(this);

	  bu.prop("disabled",true);

	 $.post("{{ url('admin-ajax/input-edit') }}",{

		 table 	: bu.attr("table"),
		 key : bu.attr("key"),
		 value 	: bu.val(),

		 _token : "{{ csrf_token() }}",

		 id 	: bu.attr("id"),

		 name	: bu.attr("name")

		 

	 },function(){

		 bu.prop("disabled",false);

		 

	 }); 

	  

  });

  $(".tags").tagsInput();

  $(".select2").select2({

	  tags: true

  });

/*

  $("form").on("submit",function(event){

//	 Codebase.layout('header_loader_on')

	 $(this).find(":submit").html("{{__('İşlem yapılıyor...')}}").prop("disabled",true); 

	  

  });

*/

  $(".ajax-form").on("submit", "form", function(event)

	{

		alert("ok");

		event.preventDefault();



		var url=$(this).attr("action");

		$.ajax({

			url: url,

			type: $(this).attr("method"),

			dataType: "JSON",

			data: new FormData(this),

			processData: false,

			contentType: false,

			success: function (data, status)

			{



			},

			error: function (xhr, desc, err)

			{





			}

		});        



	});

	$(".btn")

		.addClass("btn-noborder")

		.addClass("btn-rounded");

	$(".input-group-append .btn, .input-group-prepend .btn")

		.removeClass("btn-noborder")

		.removeClass("btn-rounded");

		

	function loadDoc(url, cFunction) {

	  var xhttp;

	  xhttp=new XMLHttpRequest();

	  xhttp.onreadystatechange = function() {

		if (this.readyState == 4 && this.status == 200) {

			

			$("body").html(xhttp.responseText);

			window.history.pushState('url',Math.random() , url);

			cFunction(this);

		}

	 };

	  xhttp.open("GET", url, true);

	  xhttp.send();

	}

	$("a").on("click",function(){

		/* 

		loadDoc($(this).attr("href"),sonuc);

		return false;

		*/

	});

	function sonuc() {

		console.log("sonuc");

	}

});

</script>