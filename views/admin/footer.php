<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>IMS Web Design</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?php echo date("Y");?> <a href="http://quad.com">IMS Technology</a>.</strong> Your IT Solutions Partner <b style="color:red;">|</b> <?php echo $this->session->userdata("ses_nama_kantor");?> 
	
	</br><?php echo '<font id="waktu_server" style="color:red;text-align:center;font-size:11px;">Waktu Server : '.date('Y-m-d H:i:s').'</font>';?>
</footer>