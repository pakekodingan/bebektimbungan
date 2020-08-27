
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bebek Timbungan - Menu</title>
        <meta name="description" content="">
        <meta name="robots" content="noindex, follow" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/plugin_menu_order/img/favicon.png">

        <!-- all css here -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/plugins.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/responsive.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/jquery-confirm.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin_menu_order/css/jquery.toast.css">
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <input type="hidden" name="" id="kode-table" value="<?php echo $KdTable; ?>">
        <input type="hidden" name="" id="base-url" value="<?php echo base_url(); ?>">
        <input type="hidden" name="" id="site-url" value="<?php echo site_url(); ?>">
        <div class="preloader">
          <div class="loading">
            <img src="<?php echo base_url(); ?>assets/images/BTS_Logo_Loader.png" width="80">
            <p>Loading...</p>
          </div>
        </div>
        <!-- header start -->
        <header class="header-area transparent-bar header-black">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-5 col-sm-4">
                        <div class="logo">
                            <a href="index.html">
                                <!-- <img alt="" src="<?php echo base_url(); ?>assets/plugin_menu_order/img/logo-black.png"> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-7 col-sm-8">
                        <div class="menu-search-bundle">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li><a href="javascript:void(0)" onclick="viewMenu()">MENU</a></li>
                                        <li><a href="javascript:void(0)" onclick="viewPesanan()">PESANAN</a></li>
                                        <li><a href="javascript:void(0)" onclick="clearTable()">CLEAR TABLE</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="search-wrap">
                                <button class="search-toggle" id="icon-loop">
                                    <i class="fa fa-search"></i>
                                </button>
                                <div class="search">
                                    <form action="#">
                                        <input type="search" placeholder="Search here" id="searchKeyword">
                                        <button type="button" id="searchProd" >
                                            Search
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area d-md-block d-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow">
                                    <li><a href="javascript:void(0)" onclick="viewMenu()"> MENU </a></li>
                                    <!-- <li><a href="javascript:void(0)" onclick="viewPesanan()"> PESANAN </a></li> -->
                                    <li><a href="javascript:void(0)" onclick="clearTable()"> CLEAR TABLE </a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="breadcrumb-area  ptb-80" style="display: none;" id="title-pesanan"  >
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h3>PESANAN</h3>
                </div>
            </div>
        </div>
        <div class="product-menu-area pt-20 pb-70 gray-bg">
            <div class="container">
                <div class="section-title text-center mb-20" id="logo-menu">
                    <img src="<?php echo base_url(); ?>assets/images/BTS_Logo.png">
                </div>

                <div class="section-title text-center mb-50" id="title-menu">
                    <h2>Our Food Menu</h2>
                </div>
                <div class="menu-tab-wrap mb-50" id="menu-categories">
                    <div class="menu-tab-list nav text-center">
                        <?php foreach ($kategori as $key => $value): ?>
                        <a class="" href="#tab<?php echo $value['KdSubKategori']; ?>" data-toggle="tab">
                            <?php echo $value['NamaSubKategori']; ?>
                        </a>
                    <?php endforeach;?>
                        <a href="#tabSearch" data-toggle="tab" id="all-menu">ALL</a>
                    </div>
                </div>
                <div class="tab-content jump" id="list-menu">
                    <?php foreach ($kategori as $key => $valKategori): ?>
                            <div id="tab<?php echo $valKategori['KdSubKategori']; ?>" class="tab-pane">
                                <div class="row">
                                <?php foreach ($menu[$valKategori['KdSubKategori']] as $valMenu): ?>
                                        <div class="col-lg-6">
                                            <div class="single-menu-product mb-30"  onclick="addCart('<?php echo $valMenu['PCode']; ?>')">
                                                <div class="menu-product-img">
                                                    <img alt="" src="<?php echo base_url(); ?>assets/images/product/empty.png">
                                                </div>
                                                <div class="menu-product-content">
                                                    <input type="hidden" id="PCode-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['PCode']; ?>">
                                                    <input type="hidden" id="ItemName-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['NamaLengkap']; ?>">
                                                    <input type="hidden" id="Price-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['Harga1c']; ?>">
                                                    <div class="menu-title-price">
                                                        <div class="menu-title">
                                                            <h4 id="product-name">
                                                                <?php echo $valMenu['NamaLengkap']; ?>
                                                            </h4>
                                                        </div>
                                                        <div class="menu-price">
                                                            <span><?php echo "Rp " . number_format($valMenu['Harga1c'], '0', ',', '.'); ?></span>
                                                        </div>
                                                    </div>
                                                    <p><?php echo $valMenu['Deskripsi']; ?></p>
                                                    <p class="label-ppn">*harga belum termasuk PPN & Service Charge.</p>

                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach;?>
                                </div>
                            </div>
                    <?php endforeach;?>
                            <div id="tabSearch" class="tab-pane active">
                                <div class="row">
                                <?php foreach ($menu_all as $valMenu): ?>
                                        <div class="col-lg-6" >
                                            <div class="single-menu-product mb-30" onclick="addCart('<?php echo $valMenu['PCode']; ?>')">
                                                <div class="menu-product-img">
                                                    <img alt="" src="<?php echo base_url(); ?>assets/images/product/empty.png">
                                                </div>
                                                <div class="menu-product-content">
                                                    <input type="hidden" id="PCode-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['PCode']; ?>">
                                                    <input type="hidden" id="ItemName-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['NamaLengkap']; ?>">
                                                    <input type="hidden" id="Price-<?php echo $valMenu['PCode']; ?>" value="<?php echo $valMenu['Harga1c']; ?>">
                                                    <div class="menu-title-price">
                                                        <div class="menu-title">
                                                            <h4 id="product-name">
                                                                <?php echo $valMenu['NamaLengkap']; ?>
                                                            </h4>
                                                        </div>
                                                        <div class="menu-price">
                                                            <span><?php echo "Rp " . number_format($valMenu['Harga1c'], '0', ',', '.'); ?></span>
                                                        </div>
                                                    </div>
                                                    <p><?php echo $valMenu['Deskripsi']; ?></p>
                                                    <p class="label-ppn">*harga belum termasuk PPN & Service Charge.</p>
                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach;?>
                                </div>
                            </div>

                </div>
                <div class="tab-content jump" id="list-pesanan"  style="display: none;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single-menu-product mb-30" style="box-shadow: 0px 7px 10px #b8c5c5">
                                <div class="menu-product-content">
                                    <div class="menu-title-price">
                                        <div class="menu-title">
                                            <h4>TABLE : <?php echo $KdTable; ?></h4>
                                            <h4 id="nama-kustomer"></h4>
                                            <input type="hidden" name="" id="NamaKustomer">
                                        </div>
                                        <div class="menu-price">
                                            <span> </span>
                                        </div>
                                    </div>
                                    <!-- <p>Note : </p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h6>ITEM PESANAN</h6>
                        </div>
                    </div>
                    <div class="row" id="fix-pesanan">

                    </div>

                    <div class="row" id="QRCode1">

                    </div>
                    <br><br>
                    <div class="row" id="lable-tambahan-item">

                    </div>
                    <div class="row" id="item-pesanan">

                    </div>
                    <div class="row" >
                        <div class="col-12 text-center" id="btn-pesanan">

                        </div>
                    </div>
                    <div class="row" id="QRCode2">

                    </div>
                </div>
            </div>
        </div>
        <div class="cart" onclick="viewPesanan()" >
            <div class="badge badge-primary label-item-cart" id="totalOrderBag"><?php echo $totalQtyOrder; ?></div>
        </div>
        <footer class="footer-area">
            <div class="footer-area-top black-bg pt-95 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-30">
                                    <h4>About Us</h4>
                                </div>
                                <div class="footer-about">
                                    <p> Lorem ipsum dolor sit amet, consecte adipisicing elit, sed do tempor eget loved dost venenatis.</p>
                                    <div class="footer-map">
                                        <a href="contact.html"><i class="ion-ios-location-outline"></i> View on map</a>
                                    </div>
                                </div>
                                <div class="social-icon">
                                    <ul>
                                        <li><a class="facebook" href="#"><i class="ion-social-facebook"></i></a></li>
                                        <li><a class="twitter" href="#"><i class="ion-social-twitter"></i></a></li>
                                        <li><a class="instagram" href="#"><i class="ion-social-instagram-outline"></i></a></li>
                                        <li><a class="googleplus" href="#"><i class="ion-social-googleplus-outline"></i></a></li>
                                        <li><a class="dribbble" href="#"><i class="ion-social-dribbble-outline"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-30">
                                    <h4>contact Us</h4>
                                </div>
                                <div class="footer-cont-info">
                                    <div class="single-footer-cont-info">
                                        <div class="cont-info-icon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <div class="cont-info-content">
                                            <p>Elizabeth Tower. 6th Floor Medtown, New York</p>
                                        </div>
                                    </div>
                                    <div class="single-footer-cont-info">
                                        <div class="cont-info-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="cont-info-content">
                                            <p>+088 01673-453290</p>
                                            <p>+088 01673-453290</p>
                                        </div>
                                    </div>
                                    <div class="single-footer-cont-info">
                                        <div class="cont-info-icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div class="cont-info-content">
                                            <a href="#">bebektimbungan@gmail.com</a>
                                            <!-- <a href="#">info@example.com</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-30">
                                    <h4>Opening Time</h4>
                                </div>
                                <div class="open-time pr-30">
                                    <ul>
                                        <li>
                                            Saturday
                                            <span>9am - 11pm</span>
                                        </li>
                                        <li>
                                            Sunday
                                            <span>Close</span>
                                        </li>
                                        <li>
                                            Monday
                                            <span>9am - 11pm</span>
                                        </li>
                                        <li>
                                            Tuesday
                                            <span>9am - 11pm</span>
                                        </li>
                                        <li>
                                            Wednesday
                                            <span>9am - 11pm</span>
                                        </li>
                                        <li>
                                            Thursday
                                            <span>9am - 11pm</span>
                                        </li>
                                        <li>
                                            Friday
                                            <span>9am - 11pm</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="footer-widget mb-40">
                                <div class="footer-title mb-30">
                                    <h4>Newsletter</h4>
                                </div>
                                <div class="newsletter-style">
                                    <p> Lorem ipsum dolor sit amet, consecte adipisicing elit, sed do.</p>
                                    <div id="mc_embed_signup" class="subscribe-form ">
                                        <form id="mc-embedded-subscribe-form" class="validate" novalidate="" target="_blank" name="mc-embedded-subscribe-form" method="post" action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&id=05d85f18ef">
                                        <div id="mc_embed_signup_scroll" class="mc-form">
                                            <input class="email" type="email" required="" placeholder="Enter your email" name="EMAIL" value="">
                                            <div class="mc-news" aria-hidden="true">
                                                <input type="hidden" value="" tabindex="-1" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef">
                                            </div>
                                            <div class="clear">
                                                <input id="mc-embedded-subscribe" class="button" type="submit" name="subscribe" value="Subscribe">
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom black-bg-2 pb-25 pt-25">
                <div class="container">
                    <div class="copyright text-center">
                        <p>Copyright Â© <a href="#">Basmoti</a>. All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- all js here -->
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/vendor/jquery-1.12.0.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/popper.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/ajax-mail.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/main.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/jquery-confirm.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugin_menu_order/js/jquery.toast.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".preloader").fadeOut();


                $("#icon-loop").click(function(){
                    $("#all-menu").trigger('click');
                });

                $("#searchProd").click(function() {
                    var filter = $("#searchKeyword").val();
                    $("#list-menu #tabSearch #product-name").each(function() {
                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                            $(this).parent().parent().parent().parent().parent().hide();
                        } else {
                            $(this).parent().parent().parent().parent().parent().show();
                        }
                    });
                });

                cron_job1();

            });

            function viewMenu(){
                $( ".preloader" ).show().delay(400).fadeOut( 400 );
                $("#list-pesanan").hide();
                $("#title-pesanan").hide();
                $("#list-menu").show();
                $("#logo-menu").show();
                $("#title-menu").show();
                $("#menu-categories").show();
                $(".meanmenu-reveal").trigger('click');
                $("#scrollUp").trigger('click');
            }

            function viewPesanan(){
                // $(".meanmenu-reveal").trigger('click');
                getPesanan();
                getPesananFix();
                $( ".preloader" ).show().delay(400).fadeOut( 400 );
                $("#list-menu").hide();
                $("#logo-menu").hide();
                $("#title-menu").hide();
                $("#menu-categories").hide();
                $("#title-pesanan").show();
                $("#list-pesanan").show();
                $("#scrollUp").trigger('click');


            }

            function addCart(pcode){

                var PCode = $("#PCode-"+pcode).val();
                var ItemName = $("#ItemName-"+pcode).val();
                var Price = $("#Price-"+pcode).val();
                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();

                 $.confirm({
                    title: ItemName,
                    // icon: 'fa fa-shopping-bag',
                    theme: 'material',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    columnClass: 'col-md-6',
                    content: '' +
                    '<form action="" class="formName"><br>' +
                    '<table width="100%" border="0">' +
                    '<tr>' +
                    '<td style="padding-right:20px;width:10px;text-align:right;">' +
                    '<button type="button" class="btn btn-primary btn-lg" onclick="minus()"><i class="fa fa-minus"></i></button>'+
                    '</td>' +
                    '<td style="width:60px;">' +
                    '<input type="text" class="qty form-control form-control-sm text-right" value="1" style="font-size:20px;" onkeypress="return isNumberKey(event)" required />' +
                    '</td>' +

                    '<td width="10%" style="padding-left:20px;width:10px;">' +
                    '<button type="button" class="btn btn-primary btn-lg" onclick="plus()"><i class="fa fa-plus"></i></button>'+
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="3"><br>' +
                    '<textarea class="note form-control-sm" placeholder="note..."></textarea>'+
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '<br></form>',
                    buttons: {
                        formSubmit: {
                            text: 'ADD TO BASKET',
                            btnClass: 'btn-blue',
                            action: function () {
                                var Qty = this.$content.find('.qty').val();
                                var Note = this.$content.find('.note').val();

                                $.ajax({
                                    url  :site_url +"/menu/addOrderTemp",
                                    type : "POST",
                                    data : {KdTable:KdTable,PCode:PCode,Qty:Qty,Note:Note},
                                    success : function(response){
                                        res = JSON.parse(response);

                                        if(res.message == 'success'){
                                            $.toast({
                                                heading: 'Success Add To Basket.',
                                                position: 'top-center',
                                                loader: false,
                                                stack: false
                                            });

                                            $("#totalOrderBag").html(res.totalQtyOrder);
                                        }else{
                                            $.toast({
                                                heading: 'Internet No Connection.',
                                                position: 'top-center',
                                                loader: false,
                                                stack: false
                                            });
                                        }
                                    },
                                    error : function(e){
                                        $.toast({
                                            heading: 'Internet No Connection.',
                                            position: 'top-center',
                                            loader: false,
                                            stack: false
                                        });
                                    }
                                });
                            }
                        },
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });
            }

            function plus(){
                qty = $(".qty");

                _qty = (qty.val() == '')? 0 : qty.val();
                nil = parseInt(_qty) + 1;
                qty.val(nil);
            }

            function minus(){
                qty = $(".qty");

                _qty = (qty.val() == '')? 0 : qty.val();

                if(_qty > 1){
                nil = parseInt(_qty) - 1;
                qty.val(nil);

                }
            }

            function isNumberKey(evt)
            {
                 var charCode = (evt.which) ? evt.which : event.keyCode
                 if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;

                 return true;
            }

            function getPesanan(){
                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();
                var base_url = $("#base-url").val();
                $.ajax({
                    url : site_url + "/menu/getPesanan",
                    type : "POST",
                    data : {KdTable:KdTable},
                    success : function(response){
                        var res = JSON.parse(response);
                        if(res.message = 'success'){
                            $("#totalOrderBag").html(res.totalQtyOrder);
                            if(res.data.length > 0){
                                var item_pesanan ='';
                                $.each(res.data,function(key,val){
                                    note = (val.Note != '' && val.Note != null) ? 'Note: '+val.Note : '';
                                    item_pesanan += '<div class="col-lg-6">'+
                                                        '<div class="single-menu-product mb-30" onclick="editCart(\''+val.IdOrderDetailTemp+'\')">'+
                                                            '<div class="menu-product-content">'+
                                                                '<input type="hidden" id="itemNameOrder-'+val.IdOrderDetailTemp+'" value="'+val.NamaLengkap+'">'+
                                                                '<input type="hidden" id="qtyOrder-'+val.IdOrderDetailTemp+'" value="'+val.Qty+'">'+
                                                                '<input type="hidden" id="noteOrder-'+val.IdOrderDetailTemp+'" value="'+val.Note+'">'+
                                                                '<div class="menu-title-price">'+
                                                                    '<div class="menu-title">'+
                                                                        '<h4>'+ val.NamaLengkap +'</h4>'+
                                                                    '</div>'+
                                                                    '<div class="menu-price">'+
                                                                        '<span>'+ val.Qty+'</span>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<p>'+note+' </p>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>';
                                });

                                $("#item-pesanan").html(item_pesanan);
                                $("#QRCode2").html('<div class="col-lg-12"><br><br><img src="'+base_url+'assets/images/QRCodeOrder/'+res.QRCode2+'?v='+ new Date().getTime()+'" style="width:200px;"></div>');
                                var btn_pesan = '<button  type="button"  class="btn btn-primary " style="width:100px;height:50px;" onclick="pesan()">PESAN</button>';
                                $("#btn-pesanan").html(btn_pesan);

                            }else{
                                $("#item-pesanan").html('<div class="col-lg-6">Empty.</div>');
                                $("#QRCode2").html('');
                            }

                        }else{
                            $.toast({
                                heading: 'Internet No Connection.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });
                        }

                    },
                    error : function(){
                        $.toast({
                            heading: 'Internet No Connection.',
                            position: 'top-center',
                            loader: false,
                            stack: false
                        });
                    }
                });
            }

            function getPesananFix(){
                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();
                var base_url = $("#base-url").val();
                $.ajax({
                    url : site_url + "/menu/getPesananFix",
                    type : "POST",
                    data : {KdTable:KdTable},
                    success : function(response){
                        var res = JSON.parse(response);
                        if(res.message = 'success'){
                            if(res.data.length > 0){
                                var item_pesanan ='';
                                $.each(res.data,function(key,val){
                                    note = (val.Note != '' && val.Note != null) ? 'Note: '+val.Note : '';
                                    item_pesanan += '<div class="col-lg-6">'+
                                                        '<div class="single-menu-product mb-30"> '+
                                                            '<div class="menu-product-content">'+
                                                                '<div class="menu-title-price">'+
                                                                    '<div class="menu-title">'+
                                                                        '<h4>'+ val.NamaLengkap +'</h4>'+
                                                                    '</div>'+
                                                                    '<div class="menu-price">'+
                                                                        '<span>'+ val.Qty+'</span>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<p>'+note+' </p>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>';
                                });

                                $("#fix-pesanan").html(item_pesanan);
                                $("#QRCode1").html('<div class="col-lg-12"><img src="'+base_url+'assets/images/QRCodeOrder/'+res.QRCode1+'?v='+ new Date().getTime()+'"  style="width:200px;"></div>');
                                $("#nama-kustomer").html(res.data[0].NamaCustomer);
                                $("#NamaKustomer").val(res.data[0].NamaCustomer);
                                $("#lable-tambahan-item").html('<div class="col-lg-6"><h6>ITEM PENDING</H6></div>');
                            }else{
                                $("#fix-pesanan").html('');
                                $("#QRCode1").html('');
                            }

                        }else{
                            $.toast({
                                heading: 'Internet No Connection.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });
                        }

                    },
                    error : function(){
                        $.toast({
                            heading: 'Internet No Connection.',
                            position: 'top-center',
                            loader: false,
                            stack: false
                        });
                    }
                });
            }

            function editCart(IdOrderDetailTemp){
                var itemNameOrder = $("#itemNameOrder-"+IdOrderDetailTemp).val();
                var qtyOrder = $("#qtyOrder-"+IdOrderDetailTemp).val();
                var noteOrder = ($("#noteOrder-"+IdOrderDetailTemp).val() != '-')? $("#noteOrder-"+IdOrderDetailTemp).val() : "";
                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();

                $.confirm({
                    title: itemNameOrder,
                    // icon: 'fa fa-shopping-bag',
                    theme: 'material',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    columnClass: 'col-md-6',
                    content: '' +
                    '<form action="" class="formName"><br>' +
                    '<table width="100%" border="0">' +
                    '<tr>' +
                    '<td style="padding-right:20px;width:10px;text-align:right;">' +
                    '<button type="button" class="btn btn-primary btn-lg" onclick="minus()"><i class="fa fa-minus"></i></button>'+
                    '</td>' +
                    '<td style="width:60px;">' +
                    '<input type="text" class="qty form-control form-control-sm text-right" value="'+qtyOrder+'" style="font-size:20px;" onkeypress="return isNumberKey(event)" required />' +
                    '</td>' +

                    '<td width="10%" style="padding-left:20px;width:10px;">' +
                    '<button type="button" class="btn btn-primary btn-lg" onclick="plus()"><i class="fa fa-plus"></i></button>'+
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="3"><br>' +
                    '<textarea class="note form-control-sm" placeholder="note...">'+noteOrder+'</textarea>'+
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '<br></form>',
                    buttons: {
                        cancel: function () {
                            $.ajax({
                                url : site_url +'/menu/cancelDetailOrder',
                                type : "POST",
                                data : {IdOrderDetailTemp:IdOrderDetailTemp,KdTable:KdTable},
                                success : function (response){
                                    res = JSON.parse(response);
                                    if(res.message == 'success'){
                                        $.toast({
                                            heading: 'Item Cancelled.',
                                            position: 'top-center',
                                            loader: false,
                                            stack: false
                                        });

                                        getPesanan();
                                    }else{
                                        $.toast({
                                            heading: 'Internet No Connection.',
                                            position: 'top-center',
                                            loader: false,
                                            stack: false
                                        });
                                    }
                                },
                                error : function(e){
                                    $.toast({
                                        heading: 'Internet No Connection.',
                                        position: 'top-center',
                                        loader: false,
                                        stack: false
                                    });
                                }

                            });
                        },
                        formSubmit: {
                            text: 'UPDATE TO BASKET',
                            btnClass: 'btn-blue',
                            action: function () {
                                var Qty = this.$content.find('.qty').val();
                                var Note = this.$content.find('.note').val();

                                $.ajax({
                                    url  :site_url +"/menu/editOrderTemp",
                                    type : "POST",
                                    data : {IdOrderDetailTemp:IdOrderDetailTemp,KdTable:KdTable,Qty:Qty,Note:Note},
                                    success : function(response){
                                        res = JSON.parse(response);

                                        if(res.message == 'success'){
                                            $.toast({
                                                heading: 'Success Update To Basket.',
                                                position: 'top-center',
                                                loader: false,
                                                stack: false
                                            });

                                            getPesanan();
                                        }else{
                                            $.toast({
                                                heading: 'Internet No Connection.',
                                                position: 'top-center',
                                                loader: false,
                                                stack: false
                                            });
                                        }
                                    },
                                    error : function(e){
                                        $.toast({
                                            heading: 'Internet No Connection.',
                                            position: 'top-center',
                                            loader: false,
                                            stack: false
                                        });
                                    }
                                });
                            }
                        },
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });


            }

            function pesan(){

                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();
                var NamaKustomer = $("#NamaKustomer").val();

                if(NamaKustomer == ''){
                    $.confirm({
                        title: 'Masukan Nama Pemesan',
                        // icon: 'fa fa-shopping-bag',
                        theme: 'material',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        columnClass: 'col-md-6',
                        content: '' +
                        '<form action="" class="formName"><br>' +
                        '<table width="100%" border="0">' +
                        '<tr>' +
                        '<td>' +
                        '<input class="nama-pemesan form-control-sm" placeholder="Input Nama Pemesan...">'+
                        '</td>' +
                        '</tr>' +
                        '</table>' +
                        '<br></form>',
                        buttons: {
                            formSubmit: {
                                text: 'PESAN',
                                btnClass: 'btn-blue',
                                action: function () {
                                    var NamaPemesan = this.$content.find('.nama-pemesan').val();

                                    kirimPesanan(KdTable,NamaPemesan);
                                }
                            },
                        },
                        onContentReady: function () {
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click');
                            });
                        }
                    });
                }else{
                    $.confirm({
                        title: 'Kirim Pesanan Tambahan ?',
                        theme: 'material',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        columnClass: 'col-md-6',
                        buttons: {
                            KIRIM:{
                                text: 'KIRIM',
                                btnClass: 'btn-blue',
                                action: function(){
                                   kirimPesanan(KdTable,NamaKustomer);
                                }
                            },
                        },
                    });
                }


            }

            function kirimPesanan(KdTable,NamaPemesan){

                var site_url = $("#site-url").val();
                $.ajax({
                    url  : site_url +"/menu/pesan",
                    type : "POST",
                    data : {KdTable:KdTable,NamaPemesan:NamaPemesan},
                    success : function(response){
                        res = JSON.parse(response);

                        if(res.message == 'success'){
                            $.toast({
                                heading: 'Success.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });

                            $("#btn-pesanan").html('');

                            getPesanan();
                            getPesananFix();
                        }else{
                            $.toast({
                                heading: 'Internet No Connection.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });
                        }
                    },
                    error : function(e){
                        $.toast({
                            heading: 'Internet No Connection.',
                            position: 'top-center',
                            loader: false,
                            stack: false
                        });
                    }
                });
            }

            // function cron_job1(){

            //     setTimeout(function(){
            //         getPesanan();
            //         getPesananFix();
            //         cron_job2();
            //     }, 5000);
            // }

            // function cron_job2(){
            //     setTimeout(function(){
            //         getPesanan();
            //         getPesananFix();
            //         cron_job1();
            //     }, 5000);
            // }

            function clearTable(KdTable){
                var KdTable = $("#kode-table").val();
                var site_url = $("#site-url").val();
                $.ajax({
                    url  : site_url +"/menu/clearTable",
                    type : "POST",
                    data : {KdTable:KdTable},
                    success : function(response){
                        res = JSON.parse(response);

                        if(res.message == 'success'){
                            $.toast({
                                heading: 'Success.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });

                            $("#btn-pesanan").html('');

                            getPesanan();
                            getPesananFix();
                        }else{
                            $.toast({
                                heading: 'Internet No Connection.',
                                position: 'top-center',
                                loader: false,
                                stack: false
                            });
                        }
                    },
                    error : function(e){
                        $.toast({
                            heading: 'Internet No Connection.',
                            position: 'top-center',
                            loader: false,
                            stack: false
                        });
                    }
                });
            }
        </script>
    </body>
</html>
