    <style>	
		@media (max-width:960px) 
		{
			#img_logo 
			{
				width: 30%;
			}
		}
	</style>
	
	<script type="text/javascript">
		var htmlobjek;
		$(document).ready(function()
		{	
		
		});
	</script>
	<header class="main-header">
		
		
		<audio id="soundBeep" preload="auto">
			<source src="<?php echo base_url();?>assets/global/eventually.mp3"></source>
			<source src="<?php echo base_url();?>assets/global/eventually.ogg"></source>
		</audio>
		
		<input type="hidden" id="jum_notif_pasien_awal"/>
	
        <!-- Logo -->
        <a href="<?=base_url();?>index.php/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?php echo '<img id="img_logo"  width="50%" src="'.base_url().'assets/global/images/logo_thumb.png" />'; ?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?php echo '<img id="img_logo"  width="50%" src="'.base_url().'assets/global/images/logo.png" />'; ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
		  <div class="navbar-custom-menu">
			
            <ul class="nav navbar-nav">
			
			
				
					<!--<span id="notifikasi_mutasi">-->
					
					<?php
						$query_cnt_akum_msg = "
							SELECT 
								A.id_pembelian AS id_pembelian
								,COALESCE(C.nama_pelanggan,'') AS pemilik
								,COALESCE(D.nama_petugas,'') AS petugas
							FROM tb_pembelian AS A
							LEFT JOIN 
									(
										SELECT id_pembelian FROM tb_cek_apar GROUP BY id_pembelian
									) AS B ON A.id_pembelian = B.id_pembelian
							LEFT JOIN tb_pelanggan AS C ON A.id_pelanggan = C.id_pelanggan
							LEFT JOIN tb_petugas AS D ON A.id_petugas = D.id_petugas
							WHERE B.id_pembelian IS NULL
							GROUP BY A.id_pembelian,COALESCE(C.nama_pelanggan,''),COALESCE(D.nama_petugas,'')
						";
						$cnt_akum_msg = $this->M_general->view_query_general($query_cnt_akum_msg);
						if(!empty($cnt_akum_msg))
						{
							$fix_akum_msg = $cnt_akum_msg->num_rows();
						}
						else
						{
							$fix_akum_msg = 0;
						}
					?>
					
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <i class="fa fa-envelope-o"></i>
						  <span class="label label-success"><?php echo $fix_akum_msg;?></span>
						</a>
						<ul class="dropdown-menu">
						  <li class="header" style="border: 1px black solid;background-color:#ffff99;text-align:center;"><?php echo $fix_akum_msg;?> APAR Yang Belum Di Cek</li>
						  <li style="border: 1px black solid; border-color: black;box-shadow: 0 7px 10px #000;">
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<?php
									if(!empty($cnt_akum_msg))
									{
										$list_result_akum = $cnt_akum_msg->result();
										foreach($list_result_akum as $row_akum)
										{
											echo'<li style="padding:2%;"><b>No Apar :</b>'.$row_akum->id_pembelian.'</li>';
											
											
											
											echo'
												<li  style="width:100%;"><!-- start message -->
													<a href="'.base_url().'transaksi-pembelian?berdasarkan=PEMBELIAN&cari='.$row_akum->id_pembelian.'"  style="width:100%;">
														<div class="pull-left">
															<i class="fa fa-fire-extinguisher"></i>
														</div>
														
														<!--
														<h4 style="width:100%;">
															PEMILIK : '.$row_akum->pemilik.'
														</h4>
														-->
														<p>PEMILIK : '.$row_akum->pemilik.'</p>
														<p>PETUGAS : '.$row_akum->petugas.'</p>
													</a>
												</li>
												<!-- end message -->
											';
											
										}
									}
								?>
							</ul>
						  </li>
							<li class="footer" style="border: 1px black solid;background-color:#ffff99;text-align:center;">
								<a href="<?php echo base_url();?>transaksi-pembelian" style="background-color:#ffff99;">.:Lihat Semua Pesan:.</a>
							</li>
						</ul>
					  </li>
					<!--</span>-->
				
					
				
				<!--<span id="notifikasi_pasien">-->
				<li class="dropdown messages-menu" id="notifikasi_pasien">
					<!-- UNTUK MENAMPUNG NOTIFIKASI PASIEN -->
				</li>
				<!--</span>-->
			
			
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url();?>assets/global/images/logo_thumb.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $this->session->userdata('ses_gbl_nama_akun');?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="height:220px;">
                    <img src="<?php echo base_url();?>assets/global/costumer/loading.gif" class="img-circle" alt="User Image">
                    <p>
						<?php //echo 'JUAL STOCK 0 : '.$this->session->userdata('ses_gnl_isJualStock0'); ;?>
						<?php echo $this->session->userdata('ses_gbl_nama_akun');?>
					  <br><?php //echo 'ADMIN APLIKASI';?>
					  <small><?php echo $this->session->userdata('ses_gbl_jenis_akun');?></small>
                      <small><?php echo $this->session->userdata('ses_gbl_alamat_akun');?></small>
					  <br>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <!--<a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#myModalProfile">Profile</a>-->
					  
					  <a href="#" data-toggle="modal" data-target="#modal_profile" class="btn btn-default btn-flat" >Profile</a>
					  
					  <!--
					  <a href="<?=base_url();?>index.php/gl-admin-data-karyawan-detail/<?php echo $this->session->userdata('ses_id_karyawan');  ?>" class="btn btn-default btn-flat">Detail</a>
					  -->
                    </div>
					
					
					
                    <div class="pull-right">
                      <a href="<?=base_url();?>logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
              </li>
            </ul>
          </div>
        </nav>
      </header>
	  
	  
	   
	
	  
	  
      
      