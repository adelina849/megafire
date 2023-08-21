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
		
		<script type='text/javascript'>
			function ubah_data_profile_akun()
			{
				var id_akun = $("#prof_id_akun").val();
				var nik = $("#prof_nik").val();
				var nama_pegawai = $("#prof_nama_pegawai").val();
				var kelamin = $("#prof_kelamin").val();
				var tampat_lahir = $("#prof_tampat_lahir").val();
				var tgl_lahir = $("#prof_tgl_lahir").val();
				var email = $("#prof_email").val();
				var tlp = $("#prof_tlp").val();
				var alamat = $("#prof_alamat").val();
				var avatar_url = $("#prof_avatar_url").val();
				var user = $("#prof_user").val();
				var pass = $("#prof_pass").val();
				var pass2 = $("#prof_pass2").val();
				var jenis_akun = $("#prof_jenis_akun").val();

				
				

				var r = confirm("Apakah anda yakin akan menyimpan perubahan data profile ?");
				if (r == true) 
				{
					if(pass == pass2)
					{
					
						$.ajax({type: "POST", url: "<?php echo base_url();?>C_dash/ubah_profil_akun/"
						, data: 
								{
									id_akun:id_akun,
									nik:nik,
									nama_pegawai:nama_pegawai,
									kelamin:kelamin,
									tampat_lahir:tampat_lahir,
									tgl_lahir:tgl_lahir,
									email:email,
									tlp:tlp,
									alamat:alamat,
									avatar_url:avatar_url,
									user:user,
									pass:pass,
									jenis_akun:jenis_akun
								}
						, cache: false
						, success:function(data)
						{ 
							//if(data==0)
							if(data == 'BERHASIL')
							{
								alert("DATA PROFIL BERHASIL DI RUBAH");
								location.reload();
							}
							else
							{
								alert("DATA PROFIL GAGAL DI RUBAH");
							}
							  
						} 
						});
					}
					else
					{
						alert("Pastikan kolom password dan konfirmasi password sama !");
						$("#prof_pass").setfocus();
					}
				}
			}
		</script>
		
		
		
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
						if(
								strtoupper($this->session->userdata('ses_gbl_jenis_akun')) == 'KABID'
								or 
								strtoupper($this->session->userdata('ses_gbl_jenis_akun')) == 'KASATPOLPP'
							)
						{
							$this->load->view('admin/sidebar_kabid_kasat');
						}
						elseif(strtoupper($this->session->userdata('ses_gbl_jenis_akun')) == 'PEMILIK')
						{
							$this->load->view('admin/sidebar_pemilik');
						}
						else
						{
							$this->load->view('admin/sidebar');
						}
						
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
					<div class="modal fade" id="modal_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><span id="keterangan_event2">Profile & Biodata Pengguna</span></h4>
							</div>
							<div class="modal-body">
								
								
								
								<!-- ISI BODY -->
								<div class="box">
								<!--<div class="box-header">-->
									
										<br/>
										  <div class="tab-pane" id="settings">
											<!-- <form class="form-horizontal"> -->
											
											
											<form role="form" action="<?php echo base_url();?>gl-profile-simpan" method="post" class="form-horizontal frm-input" enctype="multipart/form-data">
											
											
												<input type="hidden" name="prof_id_akun" id="prof_id_akun" value="<?php echo $this->session->userdata('ses_gbl_id_akun');?>"/>
											
												<div class="form-group">
													<label for="prof_nik" class="col-sm-3 control-label">NIK</label>
													<div class="col-sm-9">
														<input type="text" id="prof_nik" name="prof_nik"  maxlength="35" class="required form-control" size="35" alt="NIK" title="NIK" placeholder="*NIK" value="<?php echo $this->session->userdata('ses_gbl_nik_akun'); ?>"/>
													</div>
												</div>
												<div class="form-group">
													<label for="prof_nama_pegawai" class="col-sm-3 control-label">Nama Pegawai</label>
													<div class="col-sm-9">
														<input type="text" id="prof_nama_pegawai" name="prof_nama_pegawai"  maxlength="35" class="required form-control" size="35" alt="Nama Pegawai" title="Nama Pegawai" placeholder="*Nama Pegawai" value="<?php echo $this->session->userdata('ses_gbl_nama_akun'); ?>"/>
													</div>
												</div>
												
												<div class="form-group">
													<label for="prof_kelamin" class="col-sm-3 control-label">Jenis Kelamin</label>
													<div class="col-sm-9">
														<select name="prof_kelamin" id="prof_kelamin" class="required form-control select2" title="Jenis KELAMIN">
															<option value="<?php echo $this->session->userdata('ses_gbl_kelamin_akun'); ?>"><?php echo $this->session->userdata('ses_gbl_kelamin_akun'); ?></option>
															<option value="PRIA">PRIA</option>
															<option value="WANITA">WANITA</option>
														</select>
													</div>
												</div>
												
												<div class="form-group">
													<label for="prof_tampat_lahir" class="col-sm-3 control-label">Tempat Lahir</label>
													<div class="col-sm-9">
													<input type="text" class="form-control" name="prof_tampat_lahir" id="prof_tampat_lahir" placeholder="*Tempat Lahir" value="<?php echo $this->session->userdata('ses_gbl_tempat_lahir_akun');?>">
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 control-label">Tanggal Lahir</label>
													<div class="col-sm-9">
														<div class="input-group date">
														  <div class="input-group-addon">
															<i class="fa fa-calendar"></i>
														  </div>
														  <input name="prof_tgl_lahir" id="prof_tgl_lahir" type="text" class="required form-control pull-right settingDate" alt="Tanggal Lahir" title="Tanggal Lahir" value="<?php echo $this->session->userdata('ses_gbl_tgl_lahir_akun');?>" data-date-format="yyyy-mm-dd">
														</div>
													</div>
													<!-- /.input group -->
												</div>
												
												
												<div class="form-group">
												  <label class="col-sm-3 control-label" for="prof_tlp">No Telpon/Hp</label>
													<div class="col-sm-9">
														<input type="text" id="prof_tlp" name="prof_tlp"  maxlength="25" onkeypress="return isNumberKey(event)" class="required form-control" size="35" alt="No Telpon/Hp" title="No Telpon/Hp" placeholder="*No Telpon/Hp" value="<?php echo $this->session->userdata('ses_gbl_tlp_akun');?>"/>
													</div>
												</div>
												
												<div class="form-group">
												  <input type="hidden" id="prof_cek_email" name="prof_cek_email" />
												  <label class="col-sm-3 control-label" for="prof_email">Email</label>
													<div class="col-sm-9">
														<input type="text" id="prof_email" name="prof_email"  maxlength="35" class="email form-control" size="35" alt="Email Harus Valid" title="Email Harus Valid" placeholder="Email Harus Valid"  value="<?php echo $this->session->userdata('ses_gbl_email_akun');?>"/> <span id="prof_pesan2"></span>
													</div>
												</div>
												
												
												<div class="form-group">
												  <label class="col-sm-3 control-label" for="prof_alamat">Alamat Lengkap</label>
													<div class="col-sm-9">
														<textarea name="prof_alamat" id="prof_alamat" class="required form-control" title="Isi dengan alamat lengkap beserta RT dan RW" placeholder="*Isi dengan alamat lengkap beserta RT dan RW"><?php echo $this->session->userdata('ses_gbl_alamat_akun');?></textarea>
													</div>
												</div>
												
												<div class="box box-warning collapsed-box box-solid">
													<div class="box-header with-border">
														<h3 class="box-title">Ubah Pengguna & Password</h3>
														<div class="box-tools pull-right">
															<button class="btn btn-box-tool" data-widget="collapse"><i id="icon_form" class="fa fa-plus"></i></button>
														</div><!-- /.box-tools -->
													</div><!-- /.box-header -->
													<div class="box-body">
												
														<div class="form-group" style="color:red;">
															<label for="prof_user" class="col-sm-3 control-label">USER</label>
															<div class="col-sm-9">
															<input type="text" class="required form-control" name="prof_user" id="prof_user" placeholder="*Jangan diisi/biarkan saja jika tidak ingin merubah"  value="<?php echo $this->session->userdata('ses_gbl_user_akun');?>">
															</div>
														</div>
														
														<div class="form-group" style="color:red;">
															<label for="prof_pass" class="col-sm-3 control-label">PASSWORD</label>
															<div class="col-sm-9">
															<input type="password" class="required form-control" name="prof_pass" id="prof_pass" placeholder="*Jangan diisi jika tidak ingin merubah"  value="<?php echo $this->session->userdata('ses_gbl_pass_ori_akun');?>">
															</div>
														</div>
														
														<div class="form-group" style="color:red;">
															<label for="prof_pass2" class="col-sm-3 control-label">KONFIRMASI PASSSWORD</label>
															<div class="col-sm-9">
															<input type="password" class="required form-control" name="prof_pass2" id="prof_pass2" placeholder="*Jangan diisi jika tidak ingin merubah"  value="<?php echo $this->session->userdata('ses_gbl_pass_ori_akun');?>">
															</div>
														</div>
													</div>
												</div>
											
												<div class="form-group">
													<!--
													<div class="col-sm-offset-2 col-sm-9">
														<button type="submit" class="btn btn-danger" onclick="simpan_proses_lamaran()">Submit</button>
													</div>
													-->
													<!--
													<div class="box-footer">
														<button type="submit" class="btn btn-danger" onclick="simpan_proses_lamaran()">Submit</button>
													</div>
													-->
												</div>
											
										  </div>
										  
										 
									
									
								<!--</div> -->
								<!-- ISI BODY -->
								
								
								</div>
							<div class="modal-footer">
								<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
								<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
								
								<!--
								<button type="submit" class="btn btn-primary" onclick="simpan_update_prodile_show_modal()">Submit</button>
								-->
								
								<button type="button" class="btn btn-primary" onclick="ubah_data_profile_akun()">Simpan</button>
							</div>
							</form>
							</div>
						</div>
						</div>
					</div>
				<!-- Show MOdal - TABLE 1-->
         
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url();?>assets/adminlte/dist/js/demo.js"></script>
        <!-- page script -->

    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
</html>