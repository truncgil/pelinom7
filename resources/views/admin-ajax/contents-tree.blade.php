<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contents;
use Illuminate\Support\Facades\DB;
$p = $request->all();
$bu = Contents::where("slug",$p['id'])->first();
$contents = Contents::where("kid",$p['id'])
				->where("title","<>",'')
				->select("title","kid","slug","id")
				->get();
	?>
	<?php if($contents->count()!=0) { ?>
		<?php	
		//	echo "<ul>";
		foreach($contents AS $c) {
			if($c->title!="") {
			?>
			<li>
								<label for="menu-<?php echo($c->id) ?>" onclick="location.href='{{url("admin/contents/".$c->id)}}'" ><?php e2($c->title) ?></label>
								<input type="checkbox" slug="<?php e2($c->slug); ?>" class="kategori-tree"  id="menu-<?php echo($c->id) ?>" />
								<ol>
								  
								</ol>
								</li>
			<?php
			}
			
		}
		// echo "</ul>";
		 ?>
	
	</li>
	<?php  } ?>
<script type="text/javascript">
						$(function(){
							$(".kategori-tree").on("click",function(){
								console.log("ok");
								var bu = $(this);
								bu.parent().children("ol").html("{{__('Bekleyiniz...')}}"); 
								$.get('{{url('admin-ajax/contents-tree?id=')}}'+$(this).attr("slug"),function(d){
									bu.parent().children("ol").html(d);
								});
								//return false;
							});
						});
						</script>
 <?php
$return = null;
 ?>