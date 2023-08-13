<!DOCTYPE HTML>
    <head>
		<meta http-equiv="content-type" content="text/html" />
		<meta name="IMS Technology <?php echo date("y"); ?>" content="Dashboard Admin" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo $this->session->userdata('ses_gbl_ket_aplikasi');?> ">
		<meta name="author" content="<?php echo $this->session->userdata('ses_gbl_nama_aplikasi');?>">
		<title><?php echo $this->session->userdata('ses_gbl_judul_aplikasi');?></title>
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/global/images/logo_thumb.png">
    	
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
        
        <!-- view source dll.-->
        <!--<script type="text/javascript">
        window.addEventListener("keydown",function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault()}});document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){}return false}
        </script>
        <script type="text/javascript">
        document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18){return false}}
        </script>-->
        
        <!-- mengaktifkan javascript-->
        <!--<div align="center"><noscript>
           <div style="position:fixed; top:0px; left:0px; z-index:3000; height:100%; width:100%; background-color:#FFFFFF">
           <div style="font-family: Arial; font-size: 17px; background-color:#00bbf9; padding: 11pt;">Mohon aktifkan javascript pada browser untuk mengakses halaman ini!</div></div>
        </noscript></div>-->
        
        <!--kanan-->
        <!--<script type="text/javascript">
        function mousedwn(e){try{if(event.button==2||event.button==3)return false}catch(e){if(e.which==3)return false}}document.oncontextmenu=function(){return false};document.ondragstart=function(){return false};document.onmousedown=mousedwn
        </script>-->
        
        
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url();?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		
		
		
		<!-- UNTUK OF FB -->
		<!-- Facebook Meta Tag Open Graph by igniel.com -->
			<b:if cond='data:view.isHomepage'>
			<b:if cond='data:view.isPost'>
			<b:if cond='data:view.isPage'>
			<b:if cond='data:blog.url'>
			<meta expr:content='data:blog.url' property='og:url'/>
			</b:if>
			<meta expr:content='data:blog.title' property='og:site_name'/>
			<b:if cond='data:blog.pageName'>
			<meta expr:content='data:blog.pageName' property='og:title'/>
			</b:if></b:if></b:if></b:if>
			<meta content='blog' property='og:type'/>
			<b:if cond='data:blog.postImageUrl'>
			<meta expr:content='data:blog.postImageUrl' property='og:image'/>
			<b:else/>
			<b:if cond='data:blog.postImageThumbnailUrl'>
			<meta expr:content='data:blog.postThumbnailUrl' property='og:image'/>
			<b:else/>
			<meta content='https://4.bp.blogspot.com/-ie52Oh_wT-s/WHHi75UACjI/AAAAAAAAEYE/PnOATooq-Y4v_HVhR_AakM0G2d699uWIwCLcB/s1600/ignielcom.png' property='og:image'/>
			</b:if></b:if>
			<b:if cond='data:blog.metaDescription'>
			<meta expr:content='data:blog.metaDescription' property='og:description'/>
			<b:else/>
			<meta expr:content='data:post.snippet' property='og:description'/>
			</b:if>
			<meta expr:content='data:blog.title' property='og:site_name'/>
			<meta content='https://www.facebook.com/106660612706164' property='article:author'/>
			<meta content='https://www.facebook.com/106660612706164' property='article:publisher'/>
			<meta content='106660612706164' property='fb:admins'/>
			<meta content='1804789006468790' property='fb:app_id'/>
			<meta content='en_US' property='og:locale'/>
			<meta content='en_GB' property='og:locale:alternate'/>
			<meta content='id_ID' property='og:locale:alternate'/>
		<!-- UNTUK OF FB -->
		
    </head>
    
    <!-- <body class="skin-purple sidebar-mini" onLoad="JavaScript:loadSearchHighlight();" style="background-color:##E50083;" > -->
	
	
	<body class="skin-red sidebar-mini" onLoad="JavaScript:loadSearchHighlight();">
		
	
	
	<?php
		if(($page_content == 'gl_admin_proses_produksi') || ($page_content == 'gl_admin_h_mutasi_alokasi_produksi') || ($page_content == 'gl_admin_view_d_mutasi_out_langsung'))
		{
	?>
		<div  id="box-form" class="box box-default collapsed-box box-solid" style="z-index:99999;position:fixed;">
			<div class="box-header with-border">
				<h3 class="box-title">SCAN QRCODE</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i id="icon_form" class="fa fa-plus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				<!-- <div class="mailbox-controls" style="border:1px solid black;text-align:center;z-index:99999;position:fixed;width:50%;margin-left:25%;"> -->
				<div class="mailbox-controls" id="canvas" style="border:1px solid black;text-align:center;width:50%;margin-left:25%;">
					<!-- <video id="preview" style="width:50%; height:100px; z-index:999; border:1px solid black;"></video> -->
					<!-- <font style="font-size:12px;font-weight:bold;color:red;">SCAN QRCODE</font> -->
					
					<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons" style="margin-left:0%;">
					  <!-- <label class="btn btn-primary active"> -->
					  <label class="btn btn-secondary active">
						<input type="radio" name="options" value="1" autocomplete="off" checked> Front
					  </label>
					  <label class="btn btn-secondary">
					  <!-- <label class="btn btn-primary"> -->
						<input type="radio" name="options" value="2" autocomplete="off"> Back
					  </label>
					</div>
				
					<!-- <video id="preview" style="width:100%; z-index:999;"></video> -->
					<video id="preview" style="width:100%; z-index:999;" controls></video>
				</div>
			</div>
		</div>
	<?php
		}
	?>
	
	
	<style>
		.act-btn{
		//background:green;
		transparent:0%;
		display: block;
		//width: 150px;
		/*height: 75px;*/
		//line-height: 50px;
		text-align: center;
		color: black;
		//font-size: 30px;
		//font-weight: bold;
		/*border-radius: 50%;*/
		/*-webkit-border-radius: 50%;*/
		text-decoration: none;
		transition: ease all 0.3s;
		position: fixed;
		right: 1%;
		bottom: 0%;
		}
		//.act-btn:hover{background: #8ab933}
	</style>
	
		
		<!-- PENGUMUMAN -->
		<marquee style="color:red;width100%;">
			<?php
				
				$isi_pengumuman = "NB: Pastikan format number pemisah ribuan adalah coma(,). Hal ini akan berpengaruh terhadap format angka ketika di export seperti file excel dll.";
				echo $isi_pengumuman;
			?>
			
		</marquee>
		
		
        <div id="wrapper_utma" class="wrapper"> <!-- Buka | Untuk Wrapper/Container -->
            <!--<div> <!-- Buka | Untuk Header -->
                <?php
                    $this->load->view('admin/header');
                ?>
            <!--</div> <!-- Tutup | Untuk Header -->
            
            
                <!-- Buka | Untuk Sidebar-->
                   <?php 
						$this->load->view('admin/sidebar');
                   ?> 
                <!-- Tutup | Untuk Sidebar -->
                
                
                
                    <?php 
						$this->load->view('admin/'.$page_content.'.html');
                    ?>
                

            
            <div> <!-- Buka | Untuk Footer-->
                <?php 
                    $this->load->view('admin/footer');
                ?>
            </div> <!-- Tutup | Untuk Footer -->
            
            <div> <!-- Buka | Sidebar control-->
                <?php 
                    //$this->load->view('admin/control_sidebar');
                ?>
            </div> <!-- Tutup | Sidebar Control -->
            
        </div> <!-- Tutup | Untuk Wrapper/Container -->
        
		
					<!-- Show MOdal - TABLE 1 -->
					
					<!-- Show MOdal - TABLE 1-->
         
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
        <!-- page script -->

    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
</html>