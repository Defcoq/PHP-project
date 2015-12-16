 <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
       <!-- DATA TABLE SCRIPTS -->
       <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

    <script src="assets/js/custom.js"></script>
    <script src="bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="js/editor.js"></script>
    <script src="js/toastr.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {


        var pgurl = window.location.href.split('?')[0].substr(window.location.href.lastIndexOf("/") + 1);
        console.log(pgurl);
        $("#main-menu li a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
                $(this).addClass("active-menu");
        });


        //$('#main-menu li a').click(function (e) {
        //    e.preventDefault();

        //    $.ajax({
        //        type: "GET",
        //        url: pgurl,
        //        data: {
        //            current_active_menu: '3'
        //        },
        //        success: function (data) {
        //            alert(data);

        //        }
        //    });
        //});
       
       
    });
</script>
   