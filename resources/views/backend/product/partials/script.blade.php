<script>
	function off() {
        var actual_price;
        var sale_price;

        if($('#actual_price').val() == '' || $('#sale_price').val() == ''){
            console.log('Nothing to off');
        }else{
            actual_price = $('#actual_price').val();
            sale_price = $('#sale_price').val();
            var off = parseInt(actual_price) - parseInt(sale_price);
            var result = (parseInt(off) * 100)/parseInt(actual_price);
            $('#off').val(parseInt(result));
        }
    }

    $('#actual_price').keyup(function(event) {
        off();
    });

    $('#sale_price').keyup(function(event) {
        off();
    });
</script>