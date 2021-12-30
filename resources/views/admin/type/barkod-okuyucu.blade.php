<script src="https://unpkg.com/html5-qrcode" type="text/javascript"> </script>
<div class="content">
    <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-{{$c->icon}}"></i> {{e2($c->title)}}</h3>
            </div>
            <div class="block-content">
            
         
                <div id="reader" class="show-mobile" width="300px"></div>
                <script>
                    Html5Qrcode.getCameras().then(devices => {
  /**
   * devices would be an array of objects of type:
   * { id: "id", label: "label" }
   */
  if (devices && devices.length) {
    var cameraId = devices[0].id;
    console.log(devices.length);
    if(devices.length>1) {
        cameraId = devices[1].id;
    }
    // .. use this to start scanning.
   // $("#sonuc").load("?ajax=print-stok&noprint&id=20211117123785");
    
    const html5QrCode = new Html5Qrcode("reader");
                                html5QrCode.start(
                                cameraId, 
                                {
                                    fps: 5,    // Optional, frame per seconds for qr code scanning
                                    qrbox: { width: 250, height: 250 }  // Optional, if you want bounded box UI
                                },
                                (decodedText, decodedResult) => {
                                    // do something when code is read
                                    //alert(decodedText);
                                    $("#sonuc").load("?ajax=print-stok&noprint&id="+decodedText+"&{{rand()}}",function(d){
                                        location.href="#sonuc";
                                    });
                                    
                                    //alert(decodedResult);
                                },
                                (errorMessage) => {
                                    // parse error, ignore it.
                                })
                                .catch((err) => {
                                // Start failed, handle it.
                                });
  }
}).catch(err => {
  // handle err
});
                                // To use Html5QrcodeScanner (more info below)
                                
            </script>
                <a name="sonuc"></a>
                <div id="sonuc"></div>
                <style>
                    .print {
                        width:100% !important;
                    }
                    #qrcode {
                    display: none !important;
                }  
                </style>
            </div>
            

        </div>

    </div>
</div>