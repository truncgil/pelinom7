<?php if(!isset($col)) {

	$col = "col-6 col-md-4 col-lg-2";

} ?>

<div class="{{$col}}" id="t{{$a->id}}" id2="{{$a->id}}">

<form action="{{url('admin-ajax/cover-upload')}}" id="f{{$a->id}}"  class="d-none" enctype="multipart/form-data" method="post">

							<input type="file" name="cover" id="c{{$a->id}}" onchange="$('#f{{$a->id}}').submit();" required />

							<input type="hidden" name="id" value="{{$a->id}}" />

							<input type="hidden" name="slug" value="{{$a->slug}}" />

							{{csrf_field()}}

						</form>

			<div class="block main-block  block-rounded block-bordered block-link-shadow text-center" >

				<div class="block-header block-header-default">

					<h3 class="block-title">

						<input type="text" name="title" value="{{$a->title}}" placeholder="{{e2("Başlık Giriniz")}}" table="contents" id="{{$a->id}}" class="title{{$a->id}} form-control edit" />

					</h3>

					<div class="block-options">
<?php if(isset($a->slug)) { ?>
					<a class="btn-block-option d-none" href="{{ url($a->slug) }}" target="_blank" title="{{e2("Web'de Gör")}}">

							<i class="fa fa-globe"></i>

					</a>
<?php } ?>
					<a class="btn-block-option" href="{{ url("admin/contents/".$a->id."") }}" target="_blank" title="{{$a->title}} {{e2("Düzenle")}}">

							<i class="fa fa-pen"></i>

					</a>

					<a class="btn-block-option d-none" href="{{ url('admin-ajax/content-duplicate?cid='. $a->id ) }}"title="{{$a->title}} {{__('Çoğalt')}}">

							<i class="fa fa-copy"></i>

					</a>

					<a class="btn-block-option" href="{{ url('admin/contents/'. $a->id .'/delete') }}" ajax="#t{{$a->id}}" teyit="{{$a->title}} {{__('içeriğini silmek istediğinizden emin misiniz?')}}" title="{{$a->title}} {{__('Silinecek!')}}">

							<i class="fa fa-times"></i>

					</a>

					</div>

				</div>

				<div class="block-content">

					<p class="mt-5">

					@if($a->cover!='')

						<a href="{{ url('admin/contents/'. $a->id) }}"  >

							<img src="{{url('cache/small/'.$a->cover)}}" alt="" />

						</a>

					

						@else

					<?php foreach($types AS $t) {

						

					if($t->title==$a->type) {

						

						?>

						<a href="{{ url('admin/contents/'. $a->id) }}">

							<i class="fa fa-{{$t->icon}} fa-4x content-icon"></i>

						</a>

					<?php } } ?>

					@endif

					</p>

					<p class="font-size-h1">

						<strong>

							

						</strong>

					</p>

					<p class="font-w600">

					</p>

				</div>

				<div class="mb-10">



					<div class="block-options">

						<div class="btn-group float-left">

						<button type="button" class="btn-block-option" onclick="$('#c{{$a->id}}').trigger('click');" title="{{__('Resim Yükle')}}"><i class="fa fa-upload"></i></button>

						@if($a->cover!='')

						<a teyit="{{__('Resmi kaldırmak istediğinizden emin misiniz')}}" title="Resmi kaldır" href="{{url('admin-ajax/cover-delete?id='.$a->id)}}" class="btn-block-option"><i class="fa fa-times"></i></a>

						<a title="{{__('Resmi indir')}}" href="{{url('cache/download/'.$a->cover)}}" class="btn-block-option"><i class="fa fa-download"></i></a>

						@endif

						</div>

						<label class="css-control css-control-sm css-control-primary css-switch" title="{{e2("Yayınla/Yayından Kaldır")}}">

							<input type="checkbox" class="css-control-input yayinla" id="{{$a->id}}" @if($a->y==1)checked=""@endif>

							<span class="css-control-indicator"></span> 

						</label>

						

					</div>

				</div>

			</div>

		</div>