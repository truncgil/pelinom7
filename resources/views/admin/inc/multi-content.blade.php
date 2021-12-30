<div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{__('Çoklu İçerik Ekle')}}</h3>
            <div class="block-options">
				<button type="button" class="btn-block-option" onclick="$('.coklu').toggleClass('hidden');">
					<i class="si si-eye"></i>
				</button>
			</div>
        </div>
		

        <div class="block-content block-content-full coklu">
			<form action="{{url('admin-ajax/content-multi-add?kid='.$c->slug)}}" method="post">
			@csrf
			<div class="row">
				<div class="col-md-6">
					{{__('Bu kutuya birden fazla başlık yazarak bu alana çoklu olarak içerik ekleyebilirsiniz:')}}
					<select name="contents[]" id="" class="select2 form-control" multiple>
						<option value=""></option>
					</select>
					
					
				</div>
				<div class="col-md-6">
					{{__('Tip Seçiniz')}}
					<select name="type"  class="form-control" >
						@foreach($types AS $t)
							<option value="{{$t->title}}">{{$t->title}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-12">
					<br />
					<button class="btn btn-primary">{{__('Ekle')}}</button>
				</div>
			</div>
			
			</form>
		</div>
</div>