<table class="table">
	<tr>
		<td>{{e2("User")}}</td>
		<td>{{e2("Date")}}</td>
		<td>{{e2("Text")}}</td>
	</tr>
	<?php
		$sorgu = db("history")
			->where("kid",get("id"))
			->where("slug",get("key"))
			->orderBy("id","DESC")
			->get();
	?>
	<?php foreach($sorgu AS $s) { 
	$u = who($s->uid);
	?>
	<tr>
		<td>{{$u->name}} {{$u->surname}}</td>
		<td>{{$s->created_at}}</td>
		<td>{{$s->html}}</td>
	</tr>
	<?php } ?>
</table>