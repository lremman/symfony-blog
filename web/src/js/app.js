(function ($, undefined) {

	var loadHtml = function (url, settings) {

        if(!settings.before) {
            settings.before = function(){};
        }

        if(!settings.success) {
            settings.success = function(){};
        }

        if(!settings.error) {
            settings.error = function(){};
        }

        if(!settings.after) {
            settings.after = function(){};
        }

        if(!settings.data) {
            settings.data = {};
        }

		$.ajax({
            url: url,
            method: 'GET',
            data: settings.data,
            dataType: 'json',
            beforeSend: function(){
                settings.before();
            },
            success: function(data){
                settings.success(data);
            },
            error: function( data ) {
                settings.error(data);
            },
            complete: function(){
                settings.after();
            }
        });

	};

    $('#loadMoreArticles').on('click', function (e) {
        e.preventDefault();
        var 
            $this = $(this),
            url = $this.attr('href')
        ;

        loadHtml(url, {
            data: {
                page: $this.data('next-page')
            },
            before: function () {
                $this.addClass('disabled');
            },
            after: function() {
                $this.removeClass('disabled');
            },
            success: function (data) {

                $('.js-blog-articles').append(data.html);
                
                if (data.hasMorePages) {
                    $this.data('next-page', data.nextPage);
                } else {
                    $this.closest('#paginator').hide();
                }
            }
        });
    });

})(jQuery);	