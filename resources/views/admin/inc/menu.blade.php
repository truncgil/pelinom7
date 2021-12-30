<?php use App\Translate; ?>

<?php use App\Types; ?>

<?php $types = Types::whereNull("kid")->orderBy("s","ASC")->get(); ?>

 <div class="content-side content-side-full">

                    

                    <ul class="nav-main">

                        <li>

                            <a class="active" href="{{url('admin/')}}"><i class="si si-cup"></i><span

                                    class="sidebar-mini-hide">{{__('Dashboard')}}</span></a>

                        </li>

					

						<li class="nav-main-heading d-none"><span class="sidebar-mini-visible">UI</span><span

                                class="sidebar-mini-hidden">{{__('Content Types')}}</span></li>

								

						 @foreach($types AS $c)

						

							@if(in_array($c->title,$permissions) || in_array("ALL PRIVILEGES",$permissions))

								<li>

							<?php $alt = Types::where("kid",$c->slug)->get(); ?>

									<a  <?php if(varmi($alt)) { ?>class="nav-submenu" data-toggle="nav-submenu"<?php } ?>  href="{{ url('admin/types/'. $c->slug) }}"><i class="fa fa-{{$c->icon}}"></i><span>{{__($c->title)}}</span></a>

									<?php  if(varmi($alt)) { ?>

								

									<ul>

									<?php foreach($alt AS $a) { ?>

									@if(in_array($c->title,$permissions) || in_array("ALL PRIVILEGES",$permissions))
										<li><a href="{{ url('admin/types/'. $a->slug) }}">{{$a->title}}</a></li>

									@endif

									<?php } ?>
									</ul>

									<?php } ?>

								</li>

							@endif

							

						@endforeach

						@if(in_array("users",$permissions))

					

                        <li>

                            <a class="nav-submenu" href="{{url('admin/users')}}"><i class="si si-users"></i><span

                                    class="sidebar-mini-hide">{{__('Kullanıcılar')}}</span></a>                        

                        </li>



						@endif

                        @if(in_array("contents",$permissions))

						<li class="nav-main-heading d-none "><span class="sidebar-mini-visible">UI</span><span

                                class="sidebar-mini-hidden">{{__('Contents Tree')}}</span></li>

							

					<ol class="tree d-none">

  

  

  



						 @foreach($contents AS $c)

							@if($c->title!="")

								<li>

								<label for="menu-<?php echo($c->id) ?>" ajax=".content-ajax" onclick="location.href='{{url("admin/contents/".$c->id)}}'"><?php e2($c->title) ?></label>

								<input type="checkbox" slug="<?php e2($c->slug); ?>" class="kategori-tree"  id="menu-<?php echo($c->id) ?>" />

								<ol>

								  

								</ol>

								</li>

                                

							@endif

						@endforeach

						</ol>

						<script type="text/javascript">

						$(function(){

							$(".kategori-tree").on("click",function(){

								console.log("ok");

								var bu = $(this);

								bu.parent().children("ol").html("{{__('Loading...')}}"); 

								$.get('{{url('admin-ajax/contents-tree?id=')}}'+$(this).attr("slug"),function(d){

									bu.parent().children("ol").html(d);

								});

								//return false;

							});

						});

						</script>

						<style type="text/css">

						.contents-tree * {

							cursor:pointer;

						}

						</style>

						@endif 

						@if(in_array("new",$permissions))

						<li class="nav-main-heading"><span class="sidebar-mini-visible">UI</span><span

                                class="sidebar-mini-hidden">{{__('Content Management')}}</span></li>

                        <li>

                            <a class="nav-submenu" href="{{url('admin/new/contents')}}"><i class="si si-grid"></i><span

                                    class="sidebar-mini-hide">{{__("Contents")}}</span></a>

                          

                        </li>

                        <li>

                            <a class="nav-submenu" href="{{ url('admin/new/types') }}"><i

                                    class="si si-layers"></i><span class="sidebar-mini-hide">{{__('Types')}}</span></a>

                            

                        </li>

                        <li>

                            <a class="nav-submenu" href="{{url('admin/fields')}}"><i class="si si-list"></i><span

                                    class="sidebar-mini-hide">{{__('Columns')}}</span></a>

                           

                        </li>

						@endif

						

						@if(in_array("languages",$permissions))

                        <li class="nav-main-heading"><span class="sidebar-mini-visible">UI</span><span

                                class="sidebar-mini-hidden">{{__('Language Settings')}}</span></li>

							

							<?php 	$diller = explode(",","en,tr"); foreach($diller AS $d) { ?>

							<li>

									<a href="{{ url('admin/languages/'. $d) }}"><i class="fa fa-language"></i><span>{{__($d)}}</span></a>

								</li>

							<?php } ?>

						@endif

                    </ul>



                </div>