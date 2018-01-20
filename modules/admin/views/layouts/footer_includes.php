<!-- jQuery 2.1.4 -->
<?php /* ?><script src="plugins/jQuery/jQuery-2.1.4.min.js"></script><?php */ ?>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type="text/javascript">
  $.widget.bridge('uibutton', $.ui.button);
  
        $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

      });
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<?php /* ?><script src="<?php echo Yii::$app->request->baseUrl ?>/web/https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script><?php //*/ ?>
<?php /* ?><script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/morris/morris.min.js" type="text/javascript"></script><?php //*/ ?>
<!-- Sparkline -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- Datepicker JS -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/select2/select2.full.min.js" type="text/javascript"></script>
<!-- Choosen -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/chosen/chosen.jquery.js" type="text/javascript"></script>
<!-- inputmask -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
<!-- bootstrap-tagsinput Scripts -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/js/admin/bootstrap-tagsinput.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/js/pages/dashboard.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/js/demo.js" type="text/javascript"></script>
<!-- Custom Scripts -->
<script src="<?php echo Yii::$app->request->baseUrl ?>/web/js/admin/custom_script.js" type="text/javascript"></script>

<script src="<?php echo Yii::$app->request->baseUrl ?>/web/js/admin/jquery.fastLiveFilter.js" type="text/javascript"></script>



<!--<script src="<?php //echo Yii::$app->request->baseUrl ?>/web/js/admin/preview_invoice_script.js" type="text/javascript"></script>-->