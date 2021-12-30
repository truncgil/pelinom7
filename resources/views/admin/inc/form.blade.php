<?php 
use App\Types;
use App\Content;
use App\Fields;

 ?>	
	<form action="{{url('admin-ajax/content-update?back')}}" method="post">
		{{csrf_field()}}
			<div class="row">
				<div class="col-md-9">
					{{__('Başlık')}}
					<input type="hidden" name="id" value="{{@$c->id}}" />
					<input type="hidden" name="kid" value="{{@$c->kid}}" />
					<input type="hidden" name="oldslug" value="{{@$c->slug}}" />
					<input type="text" name="title" id="title" value="{{@$c->title}}" class="form-control" />
					
					{{__('URL')}} <div class="btn btn-default" onclick="$.get('{{url('admin-ajax/slug?title='.@$c->breadcrumb)}}'+$('#title').val(),function(d){
						$('#slug').val(d)
					})"><i class="si si-refresh"></i></div>
					<input type="text" name="slug" id="slug" value="{{@$c->slug}}" class="form-control" />
					
					{{__('İçerik Tipi')}}
					<select name="type" id="{{@$c->id}}" class="form-control edit" table="contents" >
						<option value="">Tip Seçiniz</option>
					@foreach(@$types AS $t)
						<option value="{{$t->title}}" @if($t->title==@$c->type) selected @endif>{{$t->title}}</option>
					@endforeach
					</select>
					
					{{__('İçerik')}}
					<textarea class="" id="editor" name="html">{{@$c->html}}</textarea>
					
					@include("admin.inc.fields")
				</div>
				<div class="col-md-3 text-center">
				@if(@$c->cover!='')
					<div class="js-gallery">
						<a href="{{url('cache/large/'.@$c->cover)}}" class="img-link img-link-zoom-in img-thumb img-lightbox"  target="_blank" >
							<img src="{{url('cache/small/'.@$c->cover)}}" alt="" />
						</a>
					</div>
						<hr />
						@else 
								<i class="fa fa-image" style="    display: block;
    font-size: 150px;
    color: #f3f3f3;"></i>
						@endif
						<div class="btn-group">
						<button type="button" class="btn  btn-secondary btn-sm" onclick="$('#c{{@$c->id}}').trigger('click');" title="{{__('Resim Yükle')}}"><i class="fa fa-upload"></i> {{__('Kapak Resmi Yükle')}}</button>
						@if(@$c->cover!='')
						<a teyit="{{__('Resmi kaldırmak istediğinizden emin misiniz')}}" title="{{__('Resmi kaldır')}}" href="{{url('admin-ajax/cover-delete?id='.@$c->id)}}" class="btn btn-secondary btn-sm "><i class="fa fa-times"></i></a>
						<a title="{{__('Resmi indir')}}" href="{{url('cache/download/'.@$c->cover)}}" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i></a>
						@endif
						</div>
						
				</div>
			</div>
			
			
			<hr />
			<div class="">
				<a href="{{url(@$c->slug)}}" target="_blank" class="btn btn-danger"><i class="fa fa-globe"></i> {{__(@$c->title)}} {{__('İçeriğini Web\'de Gör')}}</a>
				<button class="btn btn-primary">{{__('Değişiklikleri Kaydet')}}</button>
			</div>
		</form>