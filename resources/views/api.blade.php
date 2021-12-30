

<?php 
$email = post("email");
$password = post("password");
if (Auth::attempt(array('email' => $email, 'password' => $password))){
//	echo "Kullanıcı girişiniz başarılı. \n";
} else {
    print2($_POST);
	echo "Kullanıcı adı veya şifreniz yanlış. Lütfen tekrar deneyiniz. \n";
    exit();
}
if(getisset("route")) {
    $route = get("route");
     ?>
     @if(View::exists("api.$route"))
        @include("api.$route")
     @else 
        Geçerli bir yönlendirici bulunamadı
     @endif
     <?php 
} ?> 