</div>
<!-- /#wrapper -->

<!-- Logout Notification Box -->
<div id="logout">
    <div class="logout-message">
        <img class="img-circle img-logout" src="<?php echo Yii::app()->request->baseUrl; ?>/img/avatar.png" alt="" style="height: 150px;width: 150px;">
        <h3>
            <i class="fa fa-sign-out text-green"></i> Ready to go?
        </h3>
        <p>Click on "Sign Out" below if you are ready<br> to end your current session.</p>
        <ul class="list-inline">
            <li>
                <a href="<?php echo Yii::app()->request->baseUrl . '/auth/logout'; ?>" class="btn btn-green">
                    <strong>Sign Out</strong>
                </a>
            </li>
            <li>
                <button class="logout_close btn btn-green">Cancel</button>
            </li>
        </ul>
    </div>
</div>
<!-- /#logout -->

<!-- delete Notification Box -->
<a class="delete_box_open" style="opacity: 0;"></a>
<div id="delete_box" class="popup_box">
    <div class="logout-message">
        <h3>
            <i class="fa fa-sign-out text-green"></i> Are you Sure?
        </h3>
        <p>Select "Delete" below if you are sure<br> to delete.</p>
        <ul class="list-inline">
            <li>
                <a href="javascript:void(0);" id="delete_button" class="btn btn-green">
                    <strong>Delete</strong>
                </a>
            </li>
            <li>
                <button id="delete_box_close" class="delete_box_close btn btn-green">Cancel</button>
            </li>
        </ul>
    </div>
</div>
<!-- /#logout -->
<!-- delete Notification jQuery -->
<script>
    $(document).ready(function () {
        $('#delete_box').popup({
            transition: 'ease-in-out 0.3s',
            vertical: 'top'
        });

    });
    setTimeout(function(){
     // console.clear();  
    },500);
    
    socket.on('receive_time', function (data) {        
          console.log(data);
    });
</script>   
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/custom.js"></script>

</body>

</html>
