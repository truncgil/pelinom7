@extends('admin.master')
@section("title",__('Ana İçerikler'))
@section("desc",__('Bu sayfada ana içerikler yer almakta'))
@section('content')
<div class="content">
	<div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{__('Ana İçerikler')}}</h3>
            <div class="block-options">
                <div class="block-options-item">
				<div class="input-group">
					
					<select name="" id="" class="types_select form-control">
					@foreach($types AS $t)
						<option value="{{$t->title}}">{{$t->title}}</option>
					@endforeach
					</select>
					<div onclick="location.href='{{ url('admin-ajax/content-add?id=main&type=') }}'+$('.types_select').val()" class="input-group-append">
						<button type="button" class="btn btn-secondary">{{__('Ekle')}}</button>
					</div>
					
				</div>
					
                </div>
            </div>
        </div>
	</div>
	<div class="row gutters-tiny draggable sortable">
	@foreach($contents AS $a)
		@include("admin.inc.block")
	@endforeach
	</div>
	</div>
@endsection
