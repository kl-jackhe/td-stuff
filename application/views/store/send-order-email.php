<script>
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>store/send_order_email/<?php echo $this->session->userdata('order_number') ?>',
            data: '',
            success: function(data) {
                // if (data == '1') {
                //     //
                // } else {
                //     //
                // }
            }
        });
    });
</script>