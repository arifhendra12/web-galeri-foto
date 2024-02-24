<?php
    session_start();
    include '../config/koneksi.php';
    if ($_SESSION['status'] != 'login' ){
        echo "<script>alert('anda belum login');
        location.href='../index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Website Galery Foto</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="home.php">home</a>
                <a class="nav-link" href="album.php">album</a>
                <a class="nav-link" href="foto.php">foto</a>
                <a class="nav-link" href="../config/aksi_logout.php">logout</a>
            </div>
            </div>
        </div>
    </nav>

    <!-- content -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Tambah Album</div>
                    <div class="card-body">
                        <form action="../config/aksi_album.php" method="POST">
                            <label for="" class="form-label">Nama Album</label>
                            <input type="text" name="namaalbum"  class="form-control" required>
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                            <button class="btn btn-primary mt-2" name="tambah" type="submit" >Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Album</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $batas = 3;
                                    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
                                    
                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;
                                    
                                    $data = mysqli_query($koneksi,"select * from album");
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);
                                        $no = $halaman_awal+1;
                                    $userid = $_SESSION['userid'];
                                    $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid' limit $halaman_awal, $batas");
                                    while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['namaalbum'] ?></td>
                                    <td><?php echo $data['deskripsi'] ?></td>
                                    <td><?php echo $data['tanggaldibuat'] ?></td>
                                    <td>
                                        <!-- Button edit-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['albumid'] ?>">
                                        Edit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="edit<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../config/aksi_album.php" method="post">
                                                    <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>" >
                                                    <label for="" class="form-label">Nama Album</label>
                                                    <input type="text" name="namaalbum" value="<?php echo $data['namaalbum'] ?>" class="form-control" required>
                                                    <label for="" class="form-label" >Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control"><?php echo $data['deskripsi']; ?></textarea>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-primary mt-2" name="edit" type="submit" >Simpan Data</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>

                                        <!-- Button hapus -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['albumid'] ?>">
                                        Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="hapus<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../config/aksi_album.php" method="post">
                                                    <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>" > 
                                                    Apakah anda yakin ingin menghapus data   <strong><?php echo $data['namaalbum'] ?></strong> ?    
                                                                                            
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-danger mt-2" name="hapus" type="submit" >Hapus Data</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination ">
                                <?php
                                    for($x=1;$x<=$total_halaman;$x++){
                                ?>
                                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                <?php
                                    }
                                ?>
                                    <li class="page-item">
                                    <a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
                            </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Arif Hendra Santoso</p>
    </footer>
    
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
