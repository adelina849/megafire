
		
		<style><!-- 
        SPAN.searchword { background-color:yellow; }
        // -->
			.tooltip
			{
				/*Terserah desainnya bagaimana~*/
				background:#303030;
				padding:10px;
				color:#f0f0f0;
				border-radius:10px;
				-moz-border-radius:10px;
				width:200px;
				text-align:center;

				/*yang ini penting!*/
				position:absolute; 
			}
			
			.tooltip:before
			{
				/*wajib!*/
				content:"";
				position:absolute;
			 
				/*ini nih cara buat segitiga tanpa gambar dgn CSS*/
				border:10px solid transparent;
				border-bottom:10px solid #303030;
			 
				/*supaya lokasi segitiganya rapi*/
				top:-20px;
				left:10px;
			}
			
			.tooltip{display:none;} /*dalam keadaan biasa tidak tampil*/
			a.link:hover .tooltip{display:block;} /*ketika mouse diarahkan ke a.link, tooltip ditampilkan*/
        </style>
        <script src="<?=base_url();?>assets/global/js/searchhi.js" type="text/javascript" language="JavaScript"></script>
        <script language="JavaScript"><!--
        function loadSearchHighlight()
        {
          SearchHighlight();
          document.searchhi.h.value = searchhi_string;
          if( location.hash.length > 1 ) location.hash = location.hash;
        }
        // -->
        </script>
		
		<script type="text/javascript">
			//var htmlobjek;
			
			
			$(document).ready(function()
			{	
					//alert('<?php echo $this->session->userdata("ses_gnl_temaadmin"); ?>');
					if('<?php echo $this->session->userdata("ses_gnl_temaadmin"); ?>' == 'Style 3')
					{
						//alert("BENAR");
						window.setInterval(function() //Terus dipanggil setiap 5 detik
						{
							
							
							//PERMAINAN CSS SIDEBAR MENU
								$("li").filter('.treeview').css('border', '0px solid grey');
								$("li").filter('.treeview').css('box-shadow', '2px 2px 2px rgba(0,0,0,0.0)');
								$("li").filter('.treeview').css('margin-right', '0%');
								
								
								$("li").filter('.active').filter('.treeview').css('border', '1px dashed grey');
								$("li").filter('.active').filter('.treeview').css('box-shadow', '2px 2px 2px rgba(0,0,0,0.3)');
								$("li").filter('.active').filter('.treeview').css('margin-right', '1%');
								//$("li").filter('.active').css('background-color', '#90EE90');
								
								$("li").filter('.active').filter('.treeview').attr('class','active treeview menu-open'); //SET MENU AKTIF
							//PERMAINAN CSS SIDEBAR MENU
							
							
						}, 99);
						
						//MENGAKALI ANIMASI PANAH SIDEBAR KARENA TIDAK JALAN
						$('.treeview').hover(function() {
							var className = $('#'+this.id).attr("class");
							//alert(className); // Outputs: hint
							var position = className.search("menu-open");
							//alert(position);
							
							var position_active = className.search("active");
							//alert(position_active);
							
							//if(position >= 0)
							if(position_active >= 0)
							{
								$('#'+this.id).attr('class', 'active treeview menu-open');
							}
							else
							{
								if(position >= 0)
								{
									$('#'+this.id).attr('class', 'treeview');
								}
								else
								{
									$('#'+this.id).attr('class', 'treeview menu-open');
								}
								
							}
							
						});
						//MENGAKALI ANIMASI PANAH SIDEBAR KARENA TIDAK JALAN
					}
					else
					{
						//alert("BENAR");
						window.setInterval(function() //Terus dipanggil setiap 5 detik
						{
							
							
							//PERMAINAN CSS SIDEBAR MENU
							
								//BORDER
									$("li").filter('.treeview').css('border', '0px solid grey');
									$("li").filter('.treeview').css('box-shadow', '2px 2px 2px rgba(0,0,0,0.0)');
									$("li").filter('.treeview').css('margin-right', '0%');
									
									
									$("li").filter('.active').filter('.treeview').css('border', '1px dashed grey');
									$("li").filter('.active').filter('.treeview').css('box-shadow', '2px 2px 2px rgba(0,0,0,0.3)');
									$("li").filter('.active').filter('.treeview').css('margin-right', '1%');
									//$("li").filter('.active').css('background-color', '#90EE90');
								//BORDER
							
							
								$("li").filter('.active').filter('.treeview').attr('class','active treeview menu-open'); //SET MENU AKTIF
							//PERMAINAN CSS SIDEBAR MENU
							
							
						}, 99);
						//MENGAKALI ANIMASI PANAH SIDEBAR KARENA TIDAK JALAN
						$('.treeview').hover(function() {
							var className = $('#'+this.id).attr("class");
							//alert(className); // Outputs: hint
							var position = className.search("menu-open");
							//alert(position);
							
							var position_active = className.search("active");
							//alert(position_active);
							
							//if(position >= 0)
							if(position_active >= 0)
							{
								$('#'+this.id).attr('class', 'active treeview menu-open');
							}
							else
							{
								if(position >= 0)
								{
									$('#'+this.id).attr('class', 'treeview');
								}
								else
								{
									$('#'+this.id).attr('class', 'treeview menu-open');
								}
								
							}
							
						});
						//MENGAKALI ANIMASI PANAH SIDEBAR KARENA TIDAK JALAN
					}
					
					
				//});
				
				
				
			});
		</script>
		
		
    <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url();?>assets/global/costumer/loading.gif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('ses_gbl_nama_akun');?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form method="get" name="searchhi" class="sidebar-form" action="#">
            <div class="input-group">
              <input type="text" name="h" onkeyup="oWhichSubmit(this)" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
		  <ul class="sidebar-menu" data-widget="tree">
			<!-- CEK HAK AKSES FROM DATABASE -->
				<?php
					/*$akses_group1 = $this->m_akun->get_hak_akses_group1($this->session->userdata('ses_id_jabatan'));
					$akses_group1_main_group = $this->m_akun->get_hak_akses_group1_main_group($this->session->userdata('ses_id_jabatan'));
					$akses_group1_main_group_sub_main = $this->m_akun->get_hak_akses_group1_main_group_sub_group($this->session->userdata('ses_id_jabatan'));*/
				?>
			<!-- CEK HAK AKSES FROM DATABASE -->
		  
			
            <!-- <li class="header">MAIN NAVIGATION <?php echo $this->session->userdata('ses_akses_lvl2_47').' - '.$this->session->userdata('ses_akses_lvl2_48');?> </li> -->
			
			
			<style>
				#header-menu {
					//text-shadow: 3px 2px 1px grey;
					//font-size: 20px;
					
					box-shadow: 2px 2px 2px rgba(0,0,0,0.8);
					padding: 10px;
					border: 1px dashed grey;
				}
			</style>
							
			<li class="header" id="header-menu" style="color:white;font-weight:bold;background-color:grey;font-size:15px;z-index:999;">MAIN NAVIGATION </li>
			
			
            <!-- <li class="active treeview"> -->
			<li id="1_dashboard" class="treeview">
              <a href="<?php echo base_url()?>dashboard-admin"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
			
			
			<!-- LAPORAN -->
				<li class="treeview" id="3_laporan">
				  <a href="#">
					<i class="fa fa-book"></i> <span>Laporan</span>
					<i class="fa fa-angle-left pull-right"></i>
				  </a>
				  <ul class="treeview-menu">
						<li id="31_laporan_apar"><a href="<?php echo base_url();?>laporan-data-apar"><i class="fa fa-folder-open"></i> Lap. Data APAR </a></li>
						
						<li id="32_laporan_pemidahan_apar"><a href="<?php echo base_url();?>laporan-data-pemindahan-apar"><i class="fa fa-folder-open"></i> Lap. Pemindahan APAR </a></li>
				  </ul>
				</li>
			<!-- LAPORAN -->
				
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>