function changeSlotStatus($, slot) {
  let slod_id = '#slot-status' + slot;
  $.ajax({
    type: 'get',
    url: 'https://carparking.sttindonesia.ac.id/api/v1/sensor/latest/' + slot,
    dataType: 'json',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
    success:function(result) {
      let status = result.data[0].status; 
      if (status == '1') {
        $(slod_id).attr('src', 'dist/img/1.png');
      } else if (status == '0')
      {
        $(slod_id).attr('src', 'dist/img/0.png');
      } else {
        $(slod_id).attr('src', 'dist/img/-1.png');
      }
    },
    error:function(xhr, status, error) {
      console.log('ERROR');
      console.log(parseMessageAjaxError(xhr, status, error));                             
    },
  });  
}
(function (window, document, $) {
  'use strict';

  $(document).on('click','#btnRefreshSlot1',function(ev) {
    ev.preventDefault(); 
    changeSlotStatus($, 1);    
  }); 

  $(document).on('click','#btnRefreshSlot2',function(ev) {
    ev.preventDefault(); 
    changeSlotStatus($, 2);    
  }); 

  $(document).on('click','#btnRefreshSlot3',function(ev) {
    ev.preventDefault(); 
    changeSlotStatus($, 3);    
  }); 

  $(document).on('click','#btnRefreshSlot4',function(ev) {
    ev.preventDefault(); 
    changeSlotStatus($, 4);    
  });   

  var i = 1;

  setInterval(function() {
    console.log("notif ke " + i);
    i = i + 1;
    
    changeSlotStatus($, 1);
    changeSlotStatus($, 2);
    changeSlotStatus($, 3);
    changeSlotStatus($, 4);

  }, 60 * 1000); // 60 * 1000 milsec

})(window, document, jQuery);