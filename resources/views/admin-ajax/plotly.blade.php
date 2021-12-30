<!DOCTYPE html>
<html>
    <head>
  
        <title>OTTO2020 Analyzer App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">
        <link rel="shortcut icon" type="image/svg" href="{{url('assets/img/pivottable/logo.svg')}}"/>

        <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="https://cdn.plot.ly/plotly-basic-latest.min.js"></script>
      
        <link
			rel="stylesheet"
			type="text/css"
			href="{{ url('assets/css/pivottable/pivottable.css') }}"
        />

        <script
			type="text/javascript"
			src="{{ url('assets/js/pivottable/pivottable.js') }}"
        ></script> 

        <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.13.0/pivot.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.22.0/pivot.min.js"></script> -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.22.0/plotly_renderers.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/4.1.2/papaparse.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="https://pivottable.js.org/dist/plotly_renderers.js"></script>
        <script type="text/javascript" src="{{ url('assets/js/pivottable/custom.js') }}"></script>
        <!-- <script type="text/javascript" src="{{ url('assets/js/pivottable/pivottable_config.js') }}"></script> -->


        <!-- <style id="compiled-css" type="text/css">
            body { font-family: Verdana;}
            .c3-line, .c3-focused {stroke-width: 3px !important;}
            .c3-bar {stroke: white !important; stroke-width: 1;}
            .c3 text { font-size: 12px; color: grey;}
            .tick line {stroke: white;}
            .c3-axis path {stroke: grey;}
            .c3-circle { opacity: 1 !important; }
        </style> -->




        <!-- TODO: Missing CoffeeScript 2 -->

        <script type="text/javascript">
        //<![CDATA[
            <?php
            if (!getisset("path")) {
                //$_GET['path'] = "{$_SERVER['APP_URL']}/keyfigures-sap-merge";
                $_GET['path'] = "/keyfigures-sap-merge";
            }
            ?>

            $(function(){
                var derivers = $.pivotUtilities.derivers;
                var renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.plotly_renderers);
                var data2 ;

                <?php
                    $path = substr(get("path"), 0, 40);

                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    $abfragetool_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

                    $reset_path = explode("?", $actual_link)[0];

                    $reset_path .= "?ajax=plotly&path=";
                    $reset_path .= get("path");
                    $reset_path .= getisset("type") ? "&type=" . get("type") . "&" : "";

                
                    $csv_path = get("path");
                    $csv_path .= "?";
                    $csv_path .= getisset("type") ? "type=" . get("type") . "&" : "";
                    $csv_path .= getisset("d1") ? "d1=" . get("d1") . "&" : "";
                    $csv_path .= getisset("d2") ? "d2=" . get("d2") . "&" : "";

                    $pivottable_status = getisset("status") ? get("status") : "";

                    $analzye_type = "";

                    if ( starts_with( get( "path" ), "/keyfigures" ) ) {

                        $analzye_type = "key_sap";

                    } elseif ( starts_with( get( "type" ), "silika" ) || starts_with( get( "type" ), "schamotte" ) ) {

                        $analzye_type = "si-sa";
                        
                    } elseif ( starts_with( get( "type" ), "configration-handformerei" ) ) {

                        $analzye_type = "hand";

                    } elseif ( starts_with( get( "type" ), "configration-endbearbeitung" ) ) {

                        $analzye_type = "endbear";

                    }

                ?>
                // csv parsing
                Papa.parse("<?php echo url($csv_path) ?>", {
                    download: true,
                    skipEmptyLines: true,
                    delimiter: "|;|",	// auto-detect
	                newline: "\n",	// auto-detect
                    complete: function(parsed){
                        data2 = parsed.data;

                        $("#output").pivotUI(parsed.data, {}, true, "de");

                        let pivottable_status = '<?= $pivottable_status ?>';

                        if (pivottable_status) {
                            pivottable_status = JSON.parse(pivottable_status);

                            let wait_loaded_pivot_interval = setInterval(() => {
                                if ($("#output .pivot-loading").length === 0) {
                                    clearInterval(wait_loaded_pivot_interval);
                                    
                                    $("#tableOption .pvtRenderer").val(pivottable_status.rendererName).change();
    
                                    $("#tableOption .pvtAggregator").val(pivottable_status.aggregatorName).change();
    
                                    setTimeout(() => {
                                        $("#tableOption .pvtVals .form-control:nth-of-type(2)").val(pivottable_status.vals[0]).change();
                                    }, 1000);
    
                                    setTimeout(() => {
                                        $("#tableOption .pvtVals .form-control:nth-of-type(3)").val(pivottable_status.vals[1]).change();
                                    }, 1000);
    
                                    pivottable_status.rows.map((row)=> {
                                        $("#unused li .pvtAttr .attrName[data-name='" + row + "']").parents("li").appendTo($(".pvtRows"))
                                            .find(".attrIcon").append($("<button>", {"class": "close", "type": "button"}).html("&times;"));
                                    });
    
                                    pivottable_status.cols.map((col)=> {
                                        $("#unused li .pvtAttr .attrName[data-name='" + col + "']").parents("li").appendTo($(".pvtCols"))
                                            .find(".attrIcon").append($("<button>", {"class": "close", "type": "button"}).html("&times;"));
                                    });

                                    if (pivottable_status.exclusions.length <= pivottable_status.inclusions.length) {
                                        for (data_header in pivottable_status.exclusions) {
                                            pivottable_status.exclusions[data_header].map((sub_header) => {
                                                $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"][data-subheader="' + sub_header + '"]').prop("checked", false);
                                            });
                                        };
                                    } else {
                                        for (data_header in pivottable_status.inclusions) {
                                            $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"]').prop("checked", false);
                                            pivottable_status.inclusions[data_header].map((sub_header) => {
                                                $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"][data-subheader="' + sub_header + '"]').prop("checked", true);
                                            });
                                        };
                                    }
                                }
                            }, 500);
                        }
                    }
                });
        
                $("#dateLimitForm form").submit(function() {
                    var config = $("#output").data("pivotUIOptions");
                    var config_copy = JSON.parse(JSON.stringify(config));
                    //delete some values which will not serialize to JSON
                    delete config_copy["aggregators"];
                    delete config_copy["renderers"];
                    
                    $(this).find("input[name='status']").val(JSON.stringify(config_copy));

                    return $(this).submit();
                });

                // setInterval(() => {
                //     var config = $("#output").data("pivotUIOptions");
                //     var config_copy = JSON.parse(JSON.stringify(config));
                //     //delete some values which will not serialize to JSON
                //     delete config_copy["aggregators"];
                //     delete config_copy["renderers"];
                //     console.log(config);
                // }, 1000);

                $(".save").on("click",function(){
                    var config = $("#output").data("pivotUIOptions");
                    var config_copy = JSON.parse(JSON.stringify(config));
                    //delete some values which will not serialize to JSON
                    delete config_copy["aggregators"];
                    delete config_copy["renderers"];
                    
                    $.post(
                        "?ajax=plotly-save",
                        {
                            title : $("#title").val(),
                            data : JSON.stringify(config_copy),
                            type : "<?= $analzye_type ?>",
                            "_token" : "{{csrf_token()}}"
                        },
                        function(response) {
                            response = JSON.parse(response);
                            
                            if ( $(".dropdown-menu .dropdown-item").length != 0 ) {
                                $(".dropdown-menu").append($("<div>", {"class": "dropdown-divider"}));
                            }

                            $(".dropdown-menu").append(
                                                   $("<div>", {"class": "d-flex justify-content-around", "data-id": response.id}).append(
                                                       $("<a>", {"class": "dropdown-item w-75"}).text(response.title + " ( " + response.name + " " + response.surname + " ) ")
                                                   ).append(
                                                       $("<button>", {"class": "close"}).html("&times;")
                                                   )
                                                );
                            
                            // başka kayıt olmadığında yazılan 
                            $(".dropdown-menu .not-found-text").remove();

                            $(".save").html( "{{ e2('Saved') }}" );
                            setTimeout(() => {
                                    $(".save").html( "{{ e2('Save') }}" )
                                }, 2000);
                            $("#title").val("");
                        }
                    );
                });

                // LOAD
                $(".dropdown-menu").on("click", ".dropdown-item", function(){
                    // window.history.pushState({"html":"","pageTitle":""},"", "?id="+$(this).val());
                    // var derivers = $.pivotUtilities.derivers;
                    // var renderers = $.extend($.pivotUtilities.renderers,
                    //                         $.pivotUtilities.plotly_renderers);
                    $.get(
                        "?ajax=plotly-load",
                        {
                            id: $(this).parent().attr("data-id"),
                        },
                        function(response){
                            response = JSON.parse(response);
                            
                            $("#tableOption .pvtRenderer").val(response.rendererName).change();

                            $("#tableOption .pvtAggregator").val(response.aggregatorName).change();

                            setTimeout(() => {
                                $("#tableOption .pvtVals .form-control:nth-of-type(2)").val(response.vals[0]).change();
                            }, 200);

                            setTimeout(() => {
                                $("#tableOption .pvtVals .form-control:nth-of-type(3)").val(response.vals[1]).change();
                            }, 200);

                            response.rows.map((row)=> {
                                $("#unused li .pvtAttr .attrName[data-name='" + row + "']").parents("li").appendTo($(".pvtRows"))
                                    .find(".attrIcon").append($("<button>", {"class": "close", "type": "button"}).html("&times;"));
                            });

                            response.cols.map((col)=> {
                                $("#unused li .pvtAttr .attrName[data-name='" + col + "']").parents("li").appendTo($(".pvtCols"))
                                    .find(".attrIcon").append($("<button>", {"class": "close", "type": "button"}).html("&times;"));
                            });
                            
                            if (response.exclusions.length <= response.inclusions.length) {
                                for (data_header in response.exclusions) {
                                    response.exclusions[data_header].map((sub_header) => {
                                        $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"][data-subheader="' + sub_header + '"]').prop("checked", false);
                                    });
                                };
                            } else {
                                for (data_header in response.inclusions) {
                                    $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"]').prop("checked", false);
                                    response.inclusions[data_header].map((sub_header) => {
                                        $("#modalForVariable").find('input.pvtFilter[data-header="' + data_header + '"][data-subheader="' + sub_header + '"]').prop("checked", true);
                                    });
                                };
                            }

                            
                        }
                    );
                });

                $(".dropdown-menu").on("click", ".close" , function() {
                    let this_item = $(this).parent();
                    $.post(
                        "?ajax=plotly-delete",
                        {
                            id: $(this).parent().attr("data-id"),
                            "_token" : "{{csrf_token()}}"
                        },
                        function(response) {
                            if ( response ) {
                                // remove divider
                                if ( this_item.next().length > 0 ) {
                                    this_item.next().remove(); 
                                } else {
                                    // this element is last element
                                    this_item.prev().remove();
                                }

                                this_item.remove();

                                if ( $(".dropdown-menu .dropdown-item").length == 0 ) {
                                    $(".dropdown-menu").append( $("<div>", {"class": "d-flex justify-content-around not-found-text"}).append( $("<span>", {"class": "font-weight-bolder"}).text("{{e2('No Saved Analyze')}}") ) );
                                }

                                $(".dropdown-toggle").dropdown("show");
                            }
                        }
                    );
                });
            });

        //]]>
        </script>

    </head>

    <body>
    
        <div class="warning" id="war">
            <img src="{{ url('assets/img/pivottable/orientation.svg') }}">
            <div class="span">
                {{e2("Please turn your device sideways")}}
            </div>
        </div>

        <div id="pivottable_components" class="d-none">
            <button id="add_column" class="btn btn-dark btn-sm align-self-center" data-whatever=".pvtCols" type="button" data-toggle="modal" data-target="#modalForVariable">
                {{e2("Add Column")}}
            </button>
            <button id="add_row" class="btn btn-dark btn-sm" data-whatever=".pvtRows" type="button" data-toggle="modal" data-target="#modalForVariable">
                {{e2("Add Row")}}
            </button>

            <div id="reset_button" role="button" data-toggle="tooltip" title="{{e2('Reset Table')}}">
                <a href="<?= url($reset_path); ?>"> <img src="{{url('assets/img/pivottable/refresh.svg')}}" alt="{{e2('Reset Table')}}" /> </a>
            </div>
            <div id="fullscreen_icon" role="button" data-toggle="tooltip" title="{{e2('Full Screen')}}">
                <img src="{{url('assets/img/pivottable/maximize.svg')}}" alt="{{e2('Full Screen')}}">
            </div>
            <div id="sort_rows" role="button" data-toggle="tooltip" title="{{e2('Sort Rows')}}">
                <a></a>
            </div>
            <div id="sort_columns" role="button" data-toggle="tooltip" title="{{e2('Sort Columns')}}">
                <a></a>
            </div>

            <label id="table_type" class="textBold">{{e2("Table Type")}}</label>
            <label id="table_operation" class="textBold">{{e2("Table Operation")}}</label>


       </div>

        <main id="main">
            <header class="container-fluid">
                <div class="row pt-2 border-bottom">
                    
                    <div class="logo col-lg-1 col-md-2">
                        <div class="mx-auto mx-lg-0">
                            <a href="<?= url('admin/types/planning-board-dashboard') ?>">
                                <img src="{{ url('assets/img/pivottable/logo.svg') }}" width="64" />
                            </a>
                        </div>
                    </div>
                    <div id="dateLimitForm" class="col-lg-7 col-md-10">
                        <form action="<?= url($reset_path) ?>" method="get">
                            <?php
                            echo getisset("ajax") ? '<input type="hidden" name="ajax" value="' . get("ajax") . '" />' : "";
                            echo getisset("path") ? '<input type="hidden" name="path" value="' . get("path") . '" />' : "";
                            echo getisset("type") ? '<input type="hidden" name="type" value="' . get("type") . '" />' : "";
                            ?>
                            <input type="hidden" name="status" value="" />
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="textBold">{{e2("First Date")}}</label>
                                    <input id="date_limit_first" name="d1" type="date" class="form-control" value="<?= get("d1") ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="textBold">{{e2("Last Date")}}</label>
                                    <input id="date_limit_last" name="d2" type="date" class="form-control" value="<?= get("d2") ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="invisible">{{e2("Restrict")}}</label>
                                    <button id="date_limit_submit" class="btn btn-outline-dark w-100" type="submit" class="form-control">{{e2("Restrict")}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="saveLoadArea" class="col-lg-4">
                        <div id="saveLoadAreaIndicator">
                            <img src="{{ url('assets/img/pivottable/save.svg') }}" width="24" class="save_button" />
                            <img src="{{ url('assets/img/pivottable/chevron-right.svg') }}" width="24" class="close_button" />
                        </div>
                        <div class="input-group save-zone">
                            <input type="text" name="title" id="title" class="form-control" placeholder="{{e2('Name of the Analysis')}}" />
                            <div class="input-group-append">
                                <button class="btn btn-primary save">{{e2("Save")}}</button>
                            </div>
                        </div>
                        <div class="input-group load-zone">
                            <div class="dropdown w-100">
                                <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{e2("Load Chart")}}
                                </button>
                                <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">

                                    <?php
                                        $saved_analyzes = db("plotly")->where("type", $analzye_type)->leftJoin('users', 'users.id', '=', 'plotly.uid')->select("plotly.id", "plotly.title", "users.name", "users.surname")->get();
                                    ?>

                                    @forelse ($saved_analyzes as $saved_analyze)

                                        <div class="d-flex justify-content-around" data-id="{{ $saved_analyze->id }}">
                                            <a class="dropdown-item w-75" href="#" style="white-space: normal">
                                                {{ $saved_analyze->title }} ( {{ $saved_analyze->name }} {{ $saved_analyze->surname }} )
                                            </a>
                                            <button class="close">&times;</button>
                                        </div>

                                        @continue($loop->last)

                                        <div class="dropdown-divider"></div>
                                    
                                    @empty
                                    
                                        <div class="d-flex justify-content-around not-found-text">
                                            <span class="font-weight-bolder"> {{e2("No Saved Analyze")}} </span>
                                        </div>
                                    
                                    @endforelse
                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div id="output" class="mt-4">
                <div class="pivot-loading d-flex justify-content-center align-items-center mt-5 pd-5">
                    <span class="mt-5 pt-5">{{e2("Pivot Analyzer Loading...")}}</span>
                </div>
            </div>
            
            <!-- Modal of Variable -->
            <div class="modal" id="modalForVariable">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title textBold">{{e2("Variables")}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
    
                    <!-- Modal body -->
                    <div class="modal-body">
    
                    </div>
    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{e2("Close")}}</button>
                    </div>
    
                    </div>
                </div>
            </div>
        </main>

    </body>
</html>
