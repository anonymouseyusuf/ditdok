<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_SESSION['errQ'])){
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row jarak-card">
                    <div class="col m12">
                        <div class="card red lighten-5">
                            <div class="card-content notif">
                                <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                            </div>
                        </div>
                    </div>
                </div>';
            unset($_SESSION['errQ']);
        }

    	$id_nota_dinas_keluar = mysqli_real_escape_string($config, $_REQUEST['id_nota_dinas_keluar']);
    	$query = mysqli_query($config, "SELECT * FROM tbl_nota_dinas_keluar WHERE id_nota_dinas_keluar='$id_nota_dinas_keluar'");

    	if(mysqli_num_rows($query) > 0){
            $no = 1;
            while($row = mysqli_fetch_array($query)){

            if($_SESSION['id_user'] != $row['id_user'] AND $_SESSION['id_user'] != 1){
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=ndk";
                      </script>';
            } else {

    		  echo '<!-- Row form Start -->
				<div class="row jarak-card">
				    <div class="col m12">
                        <div class="card">
                            <div class="card-content">
        				        <table>
        				            <thead class="red lighten-5 red-text">
        				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
        				                Apakah Anda yakin akan menghapus data ini?</div>
        				            </thead>

        				            <tbody>
        				                <tr>
        				                    <td width="13%">No. Agenda</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$row['no_agenda'].'</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">Kode Klasifikasi</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$row['kode'].'</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">No. Isi</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$row['isi'].'</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">File</td>
        				                    <td width="1%">:</td>
                                            <td width="86%">';
                                            if(!empty($row['file'])){
                                                echo ' <a class="blue-text" href="?page=gnk&act=fnk&id_nota_dinas_keluar='.$row['id_nota_dinas_keluar'].'">'.$row['file'].'</a>';
                                            } else {
                                                echo ' Tidak ada file yang diupload';
                                            } echo '</td>
                                        </tr>
        				                <tr>
        				                    <td width="13%">Tujuan </td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$row['tujuan'].'</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">No. Nota Dinas Kelua</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$row['no_nota_dinas_keluar'].'</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">Tanggal Nota Dinas Keluar</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">'.$tgl = date('d M Y ', strtotime($row['tgl_nota_dinas_keluar'])).'</td>
        				                </tr>
                                        <tr>
                                            <td width="13%">Keterangan</td>
                                            <td width="1%">:</td>
                                            <td width="86%">'.$row['keterangan'].'</td>
                                        </tr>
        				            </tbody>
    				   		    </table>
				            </div>
                            <div class="card-action">
        		                <a href="?page=ndk&act=del&submit=yes&id_nota_dinas_keluar='.$row['id_nota_dinas_keluar'].'" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        		                <a href="?page=ndk" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row form END -->';

            	if(isset($_REQUEST['submit'])){
            		$id_nota_dinas = $_REQUEST['id_nota_dinas_keluar'];

                    //jika ada file akan mengekseskusi script dibawah ini
                    if(!empty($row['file'])){

                        unlink("upload/nota_dinas_keluar/".$row['file']);
                        $query = mysqli_query($config, "DELETE FROM tbl_nota_dinas_keluar WHERE id_nota_dinas_keluar='$id_nota_dinas_keluar'");

                		if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=ndk");
                            die();
                		} else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=ndk&act=del&id_nota_dinas_keluar='.$id_nota_dinas_keluar.'";
                                  </script>';
                		}
                	} else {

                        //jika tidak ada file akan mengekseskusi script dibawah ini
                        $query = mysqli_query($config, "DELETE FROM tbl_nota_dinas_keluar WHERE id_nota_dinas_keluar='$id_nota_dinas_keluar'");

                        if($query == true){
                            $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                            header("Location: ./admin.php?page=ndk");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">
                                    window.location.href="./admin.php?page=ndk&act=del&id_nota_dinas_keluar='.$id_nota_dinas_keluar.'";
                                  </script>';
                        }
                    }
                }
		    }
	    }
    }
}
?>
