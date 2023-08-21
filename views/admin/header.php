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
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <i class="fa fa-envelope-o"></i>
						  <span class="label label-success">0</span>
						</a>
						<ul class="dropdown-menu">
						  <li class="header">Anda memiliki 0 Pesan</li>
						  <li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								
							</ul>
						  </li>
						  <li class="footer"><a href="#">See All Messages</a></li>
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
                  <li class="user-header">
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
	  
	  
	   
	
	  
	  
      
      