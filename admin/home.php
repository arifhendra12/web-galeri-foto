<?php
    session_start();
    $userid = $_SESSION['userid'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php">home</a></li>
                    <li class="nav-item"><a class="nav-link" href="album.php">album</a></li>
                    <li class="nav-item"><a class="nav-link" href="foto.php">foto</a></li>
                    <li class="nav-item"><a class="nav-link" href="../config/aksi_logout.php">logout</a></li>
                </ul>
                <form class="d-flex" method="get" role="search">
                    <input class="form-control me-2" name="cari" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <?php
                   
                ?>
            </div>
            </div>
        </div>
    </nav>

    <!-- content -->
    <div class="container mt-3 mb-5">

        Album :
        <?php
            $album = mysqli_query($koneksi,"SELECT * FROM album WHERE userid='$userid'");
            while ($row = mysqli_fetch_array($album)) {
                ?>
                    <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="btn btn-outline-primary"><?php echo $row['namaalbum'] ?></a>
                <?php
            }
        ?>

        <div class="row">
        <?php
            if(isset($_GET['albumid'])){
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi,"SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <div class="col-md-3 mb-3 mt-2">
                            <div class="card">
                                <img src="../assets/img/<?php echo $data['lokasifile'] ?>" style="height: 12rem;" title="<?php echo $data['lokasifile'] ?>" class="card-img-top">
                                <div class="card-footer text-center">
                                    
                                    <?php
                                        $fotoid = $data['fotoid'];
                                        $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                                        if(mysqli_num_rows($ceksuka) == 1) {
                                            ?>
                                                <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka" ><i class="fa fa-heart"></i></a>
                                            <?php
                                        }else{
                                            ?>
                                                <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka" ><i class="fa-regular fa-heart"></i></a>
                                            <?php
                                        }
                                        $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                        echo mysqli_num_rows($like). ' suka';
                                    ?>
                                    <a href=""><i class="fa-regular fa-comment"></i></a>
                                    <?php
                                        $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                        echo mysqli_num_rows($jmlkomen).' komentar';
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            }else{

        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
        while($data = mysqli_fetch_array($query)) { ?>

            <div class="col-md-3 mt-2">
                <div class="card">
                    <img src="../assets/img/<?php echo $data['lokasifile'] ?>" style="height: 12rem;" title="<?php echo $data['lokasifile'] ?>" class="card-img-top">
                    <div class="card-footer text-center">
                        
                        <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                            if(mysqli_num_rows($ceksuka) == 1) {
                                ?>
                                    <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="batalsuka" ><i class="fa fa-heart"></i></a>
                                <?php
                            }else{
                                ?>
                                    <a href="../config/proses_like.php?fotoid=<?php echo $data['fotoid'] ?>" type="submit" name="suka" ><i class="fa-regular fa-heart"></i></a>
                                <?php
                            }
                            $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            echo mysqli_num_rows($like). ' suka';
                        ?>
                        <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i></a>
                        <?php
                                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                                echo mysqli_num_rows($jmlkomen).' komentar';
                            ?>
                    </div>
                </div>
            </div>

        <?php } }
    ?>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Arif Hendra Santoso</p>
    </footer>
    
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
