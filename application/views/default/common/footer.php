

    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>



<!-- ==== Owl Carousel Plugin ==== --> 
<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script> 
<!-- ==== Swipper Plugin ==== --> 
<script src="<?php echo base_url();?>assets/js/swiper.min.js"></script> 

<script>
	$(document).ready(function(){
  $("#small").click(function(){
    $("h2, a, p, li, h3").addClass("s");
    $("h2, a, p, li, h3").removeClass("m l xl");
  });
});
</script>

<script>
	$(document).ready(function(){
  $("#medium").click(function(){
    $("h2, a, p, li, h3").addClass("m");
    $("h2, a, p, li, h3").removeClass("s l xl");
  });
});
</script>

<script>
	$(document).ready(function(){
  $("#default").click(function(){
    $("h2, a, p, li, h3").removeClass("s m l xl");
  });
});
</script>

<script>
	$(document).ready(function(){
  $("#large").click(function(){
    $("h2, a, p, li, h3").addClass("l");
    $("h2, a, p, li, h3").removeClass("m s xl");
  });
});
</script>

<script>
	$(document).ready(function(){
  $("#extra-large").click(function(){
    $("h2, a, p, li, h3").addClass("xl");
    $("h2, a, p, li, h3").removeClass("m l s");
  });
});
</script>
<script type="text/javascript">
	 var swiper = new Swiper('.main_banner .swiper-container', {
		  spaceBetween: 0,
		  slidesPerView: 1,
		  loop: true,
		  navigation: {
			nextEl: '.main_banner .swiper-button-next',
			prevEl: '.main_banner .swiper-button-prev',
		  },
		  pagination: {
			el: '.swiper-pagination',
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '"><img src="<?php echo base_url();?>assets/img/banner-img/flag_'+(index + 1)+'.png"></span>';
			},
		  },
		  autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		  },
		  speed:1000
    });
	 var swiper = new Swiper('.news_area .swiper-container', {
		  spaceBetween: 12,
		  direction: 'vertical',
		  slidesPerView: 'auto',
		  loop: true,
		  pagination: {
			el: '.swiper-pagination',
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '"><img src="<?php echo base_url();?>assets/img/banner-img/flag_'+(index + 1)+'.png"></span>';
			},
		  },
		  autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		  },
		  speed:1000
    });
	$(".swiper-container").hover(function() {
		swiper.autoplay.stop();
	}, function() {
		swiper.autoplay.start();
	});
	var swiper = new Swiper('.photo_gallery .swiper-container', {
		  spaceBetween: 2,
		  slidesPerView: 'auto',
		  navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		  },
		  autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		  },
		  speed:1000
    });
	
</script> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/front/lightgallery.css">
<script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets/js/lightgallery.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets/js/lg-zoom.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>assets/js/lg-video.js"></script>
<script>
$(document).ready(function(){
	$('#lightgallery').lightGallery();
});
</script>
<!-- ==== Main JavaScript ==== --> 
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<div class="footer">
  	<div class="container">
    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 footer_links">
        	<h2>Contact us</h2>
            <p>
            	<strong>Nashik Municipal Corporation</strong><br>
                Rajiv Gandhi Bhavan,<br>
                Sharanpur Road<br>
                Nashik<br>
                Telephone(PBX) : 0253 - 2575631 / 2 / 3 / 4 
            </p>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 footer_links">
        	<h2>Links</h2>

<?php if($footermenu)
{
	$i=1;
	?>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <ul>
      <?php          	
	foreach ($footermenu as $val)
	{
		$link='#';
		if ($val->link_type == "C"){$link=base_url('home/getfrontpage/').$val->page_id;}
		if ($val->link_type == "L"){$link=$val->link;}
		$target="";if($val->open_in_new_window ==1) {$target='target="_blank"';}
			if($i%7 == 0)
			{
		?>
        		</ul>
                </div>	
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    			<ul>
       <?php
			}
			?>
            	<li><a href="<?php echo $link;?>" title="<?php echo $val->name;?>" <?php echo $target;?>> <?php echo $val->name;?> </a></li>
               
       <?php
	   $i++;
	}
	?>
    </ul>
    </div>
   <?php
}?>
         
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 footer_links">
        	<h2>Total Visitor » <strong><?php echo $this->count_visitor;?></strong></h2>
            <div class="social">
            	<h2>Social Initiatives</h2>
                <a href="https://www.facebook.com/nashikcorporation" target="_blank" class="fb">&nbsp;</a><a href="https://twitter.com/NashikCorp" target="_blank" class="tweet">&nbsp;</a><a href="https://www.youtube.com/user/nashikcorporation" target="_blank" class="youtube">&nbsp;</a><a href="#" target="_blank" class="gplus">&nbsp;</a>
                <div class="clear">&nbsp;</div>
            	<img src="img/sb.png" alt="" width="120" style="margin-top:12px;">
            </div>
        </div>
    	<div class="clear">&nbsp;</div>
    </div>
        <div class="copyright">
        	All rights reserved. Nashik Municipal Corporation.
        </div>
  </div>
  <!-- Back To Top Button Start -->
  <div id="backToTop"> <a href="#top" class="AnimateScrollLink"><i class="fa fa-angle-up"></i></a> </div>
  <!-- Back To Top Button End --> 
</div>
</body>
</html>