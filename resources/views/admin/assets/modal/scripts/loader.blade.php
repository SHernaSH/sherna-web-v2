<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('click', '.click-modal', function(e){

            e.preventDefault();
            e.stopImmediatePropagation();
            var url = $(this).data('url');
            var content = '.dynamic-content';
            var loader = '.modal-loader';

            $(content).html(''); // leave it blank before ajax call
            $(loader).show();      // load ajax loader

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'url' : document.getElementById('url').value,
                    'name-1' : document.getElementById('name-1').value,
                    'name-2' : document.getElementById('name-2').value,
                    'public' : document.getElementById('public').value
                },
                dataType: 'html'
            })
                .done(function(data){
                    console.log(data);
                    $(content).html('');
                    $(content).html(data); // load response
                    $(loader).hide();        // hide ajax loader
                })
                .fail(function(){
                    $(content).html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                    $(loader).hide();
                });

        });

    });
</script>
