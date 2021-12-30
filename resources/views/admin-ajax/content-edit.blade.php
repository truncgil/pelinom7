<?php 
namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Contents;
use App\Types;
use App\Fields;
use Illuminate\Support\Facades\DB;
$c = c(get("cid"));
$types = Types::get();
$fields = Fields::get();
 ?>
<form action="{{url('admin-ajax/content-update?back')}}" id="edit-form" method="post">
		{{csrf_field()}}
			<div class="row">
				<div class="col-md-12">
					{{__('Başlık')}}
					<input type="hidden" name="id" value="{{$c->id}}" />
					<input type="hidden" name="kid" value="{{$c->kid}}" />
					<input type="hidden" name="oldslug" value="{{$c->slug}}" />
					<input type="text" name="title" id="title" value="{{$c->title}}" class="form-control" />
					
					{{__('URL')}} <div class="btn btn-default" onclick="$.get('{{url('admin-ajax/slug?title='.$c->breadcrumb)}}'+$('#title').val(),function(d){
						$('#slug').val(d)
					})"><i class="si si-refresh"></i></div>
					<input type="text" name="slug" id="slug" value="{{$c->slug}}" class="form-control" />
					
					{{__('İçerik Tipi')}}
					<select name="type" id="{{$c->id}}" class="form-control edit" table="contents" >
						<option value="">Tip Seçiniz</option>
					@foreach(@$types AS $t)
						<option value="{{$t->title}}" @if($t->title==$c->type) selected @endif>{{$t->title}}</option>
					@endforeach
					</select>
					
					{{__('İçerik')}}
					<textarea id="editor" name="html">{{$c->html}}</textarea>
					<script type="text/javascript">
CKEDITOR.replace( 'editor', {
    language: '{{App::getLocale()}}',
	removePlugins: 'image',
	extraPlugins: 'base64image'
  
});
</script>
<?php sf("#edit-form"); ?>
					
				</div>
			
			</div>
			
			
			<hr />
			<div class="">
				<button class="btn btn-primary">{{__('Değişiklikleri Kaydet')}}</button>
			</div>
		</form>