
<?php use App\Translate ?><div class="block ">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{__('Çeviriler')}}</h3>
            <div class="block-options">
			<button type="button" class="btn-block-option" onclick="$('.ceviriler').toggleClass('hidden');">
				<i class="si si-eye"></i>
			</button>
		</div>
        </div>
		

        <div class="block-content block-content-full ceviriler">
				<?php $diller = explode(",",__('Diller')); foreach($diller AS $d) { ?>
					<?php $ceviri = Translate::where("dil",$d)->where("kr",md5($c->html))->first();
					if(!$ceviri) {
						$tr = new Translate;
						$tr->icerik = $c->html;
						$tr->kr = md5($c->html);
						$tr->dil = $d;
						$tr->ceviri = $c->html;
						$tr->save();
						$ceviri = Translate::where("dil",$d)->where("kr",md5($c->html))->first();
					}
					?>
					<form action="{{url('admin-ajax/input-edit')}}" class="seri" method="post">
					@csrf
						<label>{{__($d)}}</label>
						<input type="hidden" name="id" value="{{@$ceviri->id}}" />
						<input type="hidden" name="table" value="translate" />
						<input type="hidden" name="name" value="ceviri" />
						<textarea name="value" id="" cols="30" rows="10" class="ckeditor">{{@$ceviri->ceviri}}</textarea>
						<br />
						<button class="btn btn-primary">{{__('Değişiklikleri Kaydet')}}</button> <br /> 
						<hr />
						<br />
					</form>
				<?php } ?>
		</div>
</div>
<?php // sf(".seri"); ?>