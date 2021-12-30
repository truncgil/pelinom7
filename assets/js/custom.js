$(document).ready(function () {

	$("#sidebarCollapse").on("click", function () {
		$("#sidebar").addClass("active");
	});

	$("#sidebarCollapseX").on("click", function () {
		$("#sidebar").removeClass("active");
	});

	$("#sidebarCollapse").on("click", function () {
		if ($("#sidebar").hasClass("active")) {
			$(".overlay").addClass("visible");
			console.log("it's working!");
		}
	});

	$("#sidebarCollapseX").on("click", function () {
		$(".overlay").removeClass("visible");
	});

	$('.main-slider').owlCarousel({
		loop: true,
		nav: true,
		slideSpeed: 500,
		singleItem: true,
		items: 1,
		margin: 0,
		navText: ['<img class="slider-arrow" src="assets/images/left-chevron.svg" alt="Öncesi">', '<img class="slider-arrow" src="assets/images/right-chevron.svg" alt="Sonrası">'],
		dots: true,
		animateIn: 'slideInRight',
		animateOut: 'slideOutRight'
	});

	$('.sil.btn').on('click', function () {
		setTimeout(() => {
			console.log("asdasdasd");
			$.ajax({
				url: 'core.php?ajax=sepet-icerik',
				method: 'GET',
				success: function(ret){
					console.log(ret);
					$('.cart-total-total').html(ret);
					
				}
			});
		}, 600);
	});






});


window.onload = function () {
	setTimeout(() => {
		$('.preloader-field').fadeOut(function () {
			$('.preloader-field').hide();
		});
	}, 1500);
}