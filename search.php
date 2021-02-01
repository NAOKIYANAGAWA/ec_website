<?php
require_once(__DIR__ . '/config/config.php');

$item = new \ec_website\Item();
$CustomHTML = new \ec_website\CustomHTML();
$Ajax = new \ec_website\Ajax();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<title>商品一覧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="EC SITE" />
	<link rel="stylesheet" href="css/mycss/home.css">
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="css/shop.css" type="text/css" media="screen" property="" />
	<link href="css/style7.css" rel="stylesheet" type="text/css" media="all" />
	<!-- Owl-carousel-CSS -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui1.css">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->
	<link href="//fonts.googleapis.com/css?family=Montserrat:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
	    rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
	<!-- banner -->
<div class="banner_top innerpage" id="home">
		
		<div class="services-breadcrumb_w3ls_agileinfo">
			<div class="inner_breadcrumb_agileits_w3">

				<ul class="short">
					<li><a href="index.php">Home</a><i>|</i></li>
					<?php
						if (!empty($_SESSION["user"])) {
							echo '<li><a href="addItem.php">商品管理</a></li>';
						} else {
							echo '<li><a href="login.php">Login</a></li>';
						} 
					?>
				</ul>
				
			</div>
			
		</div>

</div>

<div class="search_window">
	<form class="" action="" method="post">
	  <input id="search_window_input" class="search_window_input" type="text" name="search_window_input" value="" placeholder="Search" autofocus autocomplete="off" list="search_window_datalist">
	  <button type="submit" class="button" name="search-button">検索</button>
	  <datalist id="search_window_datalist" class="search_window_datalist"></datalist>
	</form>
</div>
<script>
		//オートコンプリート
		$(function(){
		    // Ajax button click
		    $(document).on('keyup', '#search_window_input', function() {
		        $.ajax({
		            url:'<?php echo SITE_URL . "/ajax.php";?>',
		            type:'POST',
		            data:{
		                'search_window_input':$('#search_window_input').val()
		                //'test': => name
		                //$('#test') => id
		                //'val() => value
		            }
		        })
		        // Ajaxリクエストが成功した時発動
		        .done( (data) => {
		            $('.search_window_datalist').html(data);
		        })
		        // Ajaxリクエストが失敗した時発動
		        .fail( (data) => {
		            //処理
		        })
		        // Ajaxリクエストが成功・失敗どちらでも発動
		        .always( (data) => {
		          //処理
		        });
		    });
		});
	</script>

	<!-- product -->
	<div class="product-sec1">

		<?php foreach ($item->searchItem() as $value) : ?>
		<div class="product-men re">
			<div class="product-shoe-info shoe">
				<div class="men-pro-item">
					<div class="men-thumb-item">
						<img src="<?php $item->getSinglePicPass($value['ID']); ?>" alt="">
						<div class="men-cart-pro">
							<div class="inner-men-cart-pro">
								<a href="single.php?data=<?php echo $value['ID'];?>" class="link-product-add-cart">Quick View</a>
							</div>
						</div>
						<span class="product-new-top">New</span>
					</div>
					<div class="item-info-product">
						<h4>
							<a href="single.php?data=<?php echo $value['ID'];?>"><?php echo $value['item_name'];?></a>
						</h4>
						<div class="info-product-price">
							<div class="grid_meta">
								<div class="product_price">
									<div class="grid-price ">
										<span class="money "><?php echo $CustomHTML->custumPriceValue($value['item_price']);?></span>
									</div>
								</div>
								<ul class="stars">
									<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
								</ul>
							</div>
							<div class="shoe single-item hvr-outline-out">
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="add" value="1">
									<input type="hidden" name="shoe_item" value="Bella Toes">
									<input type="hidden" name="amount" value="675.00">
									<button type="submit" class="shoe-cart pshoe-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
									<a href="#" data-toggle="modal" data-target="#myModal1"></a>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>

	</div>

	<!-- product -->
	
	 <!--js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	 <!--//js -->
	 <!--cart-js -->
	<script src="js/minicart.js"></script>
	<script>
		shoe.render();

		shoe.cart.on('shoe_checkout', function (evt) {
			var items, len, i;

			if (this.subtotal() > 0) {
				items = this.items();

				for (i = 0, len = items.length; i < len; i++) {}
			}
		});
	</script>
	 <!--//cart-js -->
	 <!--/nav -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<script src="js/classie.js"></script>
	<script src="js/demo1.js"></script>
	<!-- //nav -->
	<!--search-bar-->
	<script src="js/search.js"></script>
	<!--//search-bar-->
	<!-- price range (top products) -->
	<script src="js/jquery-ui.js"></script>
	<script>
		//<![CDATA[ 
		$(window).load(function () {
			$("#slider-range").slider({
				range: true,
				min: 0,
				max: 9000,
				values: [50, 6000],
				slide: function (event, ui) {
					$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
				}
			});
			$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

		}); //]]>
	</script>
	 <!--//price range (top products) -->

	 <!--start-smoth-scrolling -->
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	 <!--//end-smoth-scrolling -->
	<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
	
	

</body>

</html>