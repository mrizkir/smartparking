(function (window, document, $) {
  'use strict';

  $(document).on('click','#btnRefreshSlot2',function(ev) {
    ev.preventDefault(); 

    $.ajax({
      type: 'get',
      url: 'https://carparking.sttindonesia.ac.id/api/v1/sensor/latest/2',
      dataType: 'json',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
      success:function(result) {
        let status = result.data[0].status; 
        if (status == '1') {
          $('#slot-status-2').attr('src', 'dist/img/1.png');
        }
        // Pace.stop();
      },
      error:function(xhr, status, error) {
        console.log('ERROR');
        // console.log(parseMessageAjaxError(xhr, status, error));  
        // Pace.stop();                         
      },
    });
  }); 

  var i = 1;

  setInterval(function() {
    console.log("notif ke " + i);
    i = i + 1;
  }, 60 * 1000); // 60 * 1000 milsec

})(window, document, jQuery);