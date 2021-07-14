<?php 

if(isset($baza)){
    $baza->close();
}
echo'           </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Moja Web stranica '.date("Y").'</div>
                            <div class="align-center">Danas je '. date("d.m.Y") .'</div>
                            <div class="footer-icons">
				                <a href="https://www.facebook.com"><i style="margin-left: 0;margin-top:5px;"class="fa fa-facebook"></i></a>
                                <a href="https://instagram.com"><i style="margin-left: 0;margin-top:5px" class="fa fa-instagram"></i></a>
                                <a href="https://youtube.com"><i style="margin-left: 0;margin-top:5px" class="fa fa-youtube"></i></a>
			                </div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
';
?>