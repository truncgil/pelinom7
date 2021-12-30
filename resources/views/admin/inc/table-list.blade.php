
<div class="block-content">
		<div class="table-responsive">
		<?php if(count($query['col'])>0) { ?>
		<table class="table table-striped table-bordered table-hover">
		
			<thead>
				<?php if(in_array("setupTime",$query['col'])) { ?>
				<tr>
					<td></td>
					<th colspan="2" class="text-center" width="20%"><?php e2("Rüst") ?></th>
					<th colspan="2" class="text-center" width="20%"><?php e2("Ausfallzeiten") ?></th>
					<td colspan="2"></td>
				</tr>
				<?php } ?>
				<tr>
				<?php foreach($query['col'] AS $a) { 
				if($a!="id") {
					if($a=="setupTime" || $a=="downTime") {
						$a = "Von";
					}
				?>
					<th class="text-center">{{e2($a)}}</th>
				<?php } ?>
				<?php } ?>
					<th>{{e2("Process")}}</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($query['row'] AS $r) { 
			$id = $r->id;
			unset($r->id);
			$class="";
			if(isset($r->setupTime)) {
				if($r->setupTime!="") {
					$class="table-success";
				} else {
					$class="table-danger";
				}
			}
			
			?>
				<tr id="t{{$id}}" class="{{$class}}">
				<?php
				
				foreach($r AS $a) { ?>
				  <td>{{$a}}</td>
				<?php } ?>
				<td><a href="{{url('admin-ajax/delete-row?id='.$id.'&table='.$query['table'])}}" teyit="{{e2("Are you sure delete this item?")}}" ajax="#t{{$id}}" class="btn btn-primary"><i class="fa fa-times"></i></a></td>
			
				</tr>
			<?php } ?>
			</tbody>
		</table>
		{{$query['links']}}
		<?php } else { 
			bilgi("No results found");
		} ?>
		
		</div>
	</div>
<script type="text/javascript">
$(function(){
	$("[rel='next'],[rel='prev']").on("click",function(){
		var parent = $(this).parent().parent().parent().parent().parent().parent();
		var ajax = parent.attr("ajax2");
		var url = $(this).attr("href").split("?");
		console.log(url);
		if(ajax!=undefined) {
			console.log(ajax);
			parent.load("{{url('admin?ajax2=')}}"+ajax+"&"+url[1]);
		}
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
});
</script>