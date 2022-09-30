// starter code for loading posts asynchronously
(function($) {
    $( document ).ready(function() {
        let currentPage = 1;
        $('#load-more').on('click', function() {
            currentPage++;
            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'json',
                data: {
                  action: 'load_more_flash',
                  paged: currentPage,
                },
                beforeSend: function() {
                    $("#loaderDiv").show();
                },
                success: function (res) {
                  setTimeout(function(){
                    $("#loaderDiv").hide();
                    if(res.length > 0) {
                      res.forEach(element => {
                        card = '<div class="et_pb_column"><h2>' + element[0] + '</h2><img src='+ element[1] +'><p> Artist: ' + element[2] + '</p> Size: <p>' + element[3] +'</p><a href="'+ element[4] +'" class=""><button class="cta">View Tattoo</button></a></div>';
                        $('.flash-tattoo-archive').append(card);
                      });
                    } else {
                      //noMore = '<div><p>No more posts</p></div>';
                      //$('.flash-tattoo-archive').append(noMore);
                      $('#no-more').show();
                    }
                  }, 1000)
                }
              });
          });
    });	
})( jQuery );